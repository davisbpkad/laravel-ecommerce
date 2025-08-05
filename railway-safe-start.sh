#!/bin/bash
set -e

echo "=== Railway Laravel Start ==="

# Debug environment
echo "DEBUG: Environment variables:"
echo "PORT value: '${PORT}'"
echo "APP_ENV: '${APP_ENV}'"
echo "DB_CONNECTION: '${DB_CONNECTION:-pgsql}'"

# Clean and validate PORT
if [ -n "$PORT" ]; then
    # Remove any quotes or whitespace
    PORT=$(echo "$PORT" | tr -d '"' | tr -d "'" | xargs)
    echo "Cleaned PORT: '$PORT'"
fi

# Validate and set PORT
if [ -z "$PORT" ] || ! [[ "$PORT" =~ ^[0-9]+$ ]] || [ "$PORT" -lt 1 ] || [ "$PORT" -gt 65535 ]; then
    echo "⚠️ Invalid or missing PORT variable (value: '$PORT'), using default 8080"
    PORT=8080
else
    echo "✅ Using PORT: $PORT"
fi

# Set permissions
echo "📁 Setting permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || echo "⚠️ Permission setting skipped"

# Setup environment file for Railway
echo "🔧 Setting up environment..."
if [ ! -f .env ]; then
    cp .env.example .env 2>/dev/null || echo "APP_ENV=production" > .env
fi

# Clear caches to avoid issues
echo "🧹 Clearing caches..."
php artisan config:clear 2>/dev/null || echo "⚠️ Config clear skipped"
php artisan route:clear 2>/dev/null || echo "⚠️ Route clear skipped"
php artisan view:clear 2>/dev/null || echo "⚠️ View clear skipped"

# Test basic PHP functionality
echo "� Testing PHP..."
php -v || exit 1

# Test artisan command
echo "🔍 Testing artisan..."
php artisan --version || exit 1

echo "�🚀 Starting Laravel server on 0.0.0.0:$PORT"

# Start Laravel with error output
exec php artisan serve --host=0.0.0.0 --port=$PORT --verbose
