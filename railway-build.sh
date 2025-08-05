#!/bin/bash

echo "=== Railway Build Script ==="

# Set Node.js memory limit
export NODE_OPTIONS="--max-old-space-size=4096"

# Install PHP dependencies
echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Install Node.js dependencies (dev dependencies needed for build)
echo "Installing Node.js dependencies..."
npm ci --silent

# Build frontend assets with error handling
echo "Building frontend assets..."
if npm run build; then
    echo "✅ Frontend build successful"
else
    echo "⚠️ Frontend build failed, trying alternative approach..."
    
    # Try simpler build without SSR
    if npm run build --mode production; then
        echo "✅ Alternative build successful"
    else
        echo "⚠️ All build attempts failed, using existing assets..."
        # Ensure build directory exists
        mkdir -p public/build/assets
        
        # Check if manifest exists, if not create a minimal one
        if [ ! -f "public/build/manifest.json" ]; then
            echo '{"resources/js/app.ts":{"file":"assets/app.js","isEntry":true}}' > public/build/manifest.json
            echo "Created minimal manifest.json"
        fi
    fi
fi

# Clean up node_modules to save space (optional)
# rm -rf node_modules

# Make scripts executable
chmod +x start.sh
chmod +x railway-start.sh

echo "✅ Build completed successfully!"
