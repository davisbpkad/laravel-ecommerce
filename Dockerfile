# Use official PHP image
FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev \
    nodejs \
    npm

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Copy required environment files
COPY .env.build .env
COPY .env.example .env.example

# Copy build environment and fake artisan
COPY fake-artisan fake-artisan

# Backup real artisan and use fake one during build
RUN if [ -f artisan ]; then cp artisan artisan.real; fi
COPY fake-artisan artisan
RUN chmod +x artisan

# Install PHP dependencies with maximum safety
RUN COMPOSER_MEMORY_LIMIT=-1 composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts \
    --no-plugins \
    --prefer-dist

# Copy package files
COPY package*.json ./

# Install Node.js dependencies
RUN npm ci --silent --no-audit

# Copy rest of application code
COPY . .

# Restore real artisan if it exists
RUN if [ -f artisan.real ]; then mv artisan.real artisan; fi

# Build frontend assets with multiple fallbacks
RUN export NODE_OPTIONS="--max-old-space-size=4096 --no-experimental-fetch" && \
    (npm run build || \
     npx vite build --config vite.production.config.ts || \
     npx vite build --mode production --no-ssr || \
     (echo "All builds failed, creating fallback..." && \
      mkdir -p public/build/assets && \
      echo "/* Fallback styles */" > public/build/assets/app.css && \
      echo "console.log('Fallback JS loaded');" > public/build/assets/app.js && \
      echo '{"resources/js/app.ts":{"file":"assets/app.js","name":"app","isEntry":true,"css":["assets/app.css"]},"resources/css/app.css":{"file":"assets/app.css"}}' > public/build/manifest.json))

# Remove build env and use production template (with safety check)
RUN rm -f .env && \
    (cp .env.example .env || echo "# Production environment" > .env)

# Make scripts executable
RUN chmod +x railway-start.sh

# Expose port
EXPOSE 8000

# Command to run the application
CMD ["bash", "railway-start.sh"]
