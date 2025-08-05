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

# Copy build environment and fake artisan
COPY .env.build .env
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

# Build frontend assets
RUN npm run build || (echo "Build failed, creating fallback..." && \
    mkdir -p public/build/assets && \
    echo '{"resources/js/app.ts":{"file":"assets/app.js","isEntry":true}}' > public/build/manifest.json)

# Remove build env and use production template
RUN rm .env && cp .env.example .env

# Make scripts executable
RUN chmod +x railway-start.sh

# Expose port
EXPOSE 8000

# Command to run the application
CMD ["bash", "railway-start.sh"]
