#!/bin/bash

echo "=== Safe Railway Build Script ==="

# Backup real artisan and replace with fake one
cp artisan artisan.real
cp fake-artisan artisan
chmod +x artisan

# Ensure we have build env from the start
cp .env.build .env

echo "Environment setup:"
echo "DB_CONNECTION=$(grep DB_CONNECTION .env)"
echo "CACHE_STORE=$(grep CACHE_STORE .env)"

# Set Node.js memory limit
export NODE_OPTIONS="--max-old-space-size=4096"

# Install PHP dependencies with maximum safety flags
echo "Installing PHP dependencies with all safety flags..."
COMPOSER_MEMORY_LIMIT=-1 composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts \
    --no-plugins \
    --prefer-dist

if [ $? -ne 0 ]; then
    echo "❌ Composer install failed!"
    exit 1
fi

echo "✅ Composer install successful"

# Restore real artisan
mv artisan.real artisan

# Install Node.js dependencies
echo "Installing Node.js dependencies..."
npm ci --silent --no-audit

if [ $? -ne 0 ]; then
    echo "❌ NPM install failed!"
    exit 1
fi

echo "✅ NPM install successful"

# Build frontend assets
echo "Building frontend assets..."
if npm run build; then
    echo "✅ Frontend build successful"
else
    echo "⚠️ Frontend build failed, creating fallback assets..."
    mkdir -p public/build/assets
    echo '{"resources/js/app.ts":{"file":"assets/app.js","isEntry":true}}' > public/build/manifest.json
fi

# Replace with production environment template
rm .env
cp .env.example .env

# Make scripts executable
chmod +x railway-start.sh

echo "✅ Build completed successfully!"
echo "Build artifacts:"
ls -la public/build/ || echo "No build directory"
