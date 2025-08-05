#!/bin/bash
set -e

echo "=== Railway Simple Start ==="

# Set default port if not provided
PORT=${PORT:-8080}

echo "📦 Environment: ${APP_ENV:-production}"
echo "🔌 Port: $PORT"

# Basic health check of environment
if [ -z "$PGHOST" ]; then
    echo "⚠️ Warning: Database environment variables not fully set"
else
    echo "✅ Database environment configured"
fi

# Ensure storage directories are writable
echo "📁 Setting up storage permissions..."
chmod -R 775 storage bootstrap/cache 2>/dev/null || echo "⚠️ Permission setting failed, continuing..."

# Clear caches to avoid stale config issues
echo "🧹 Clearing caches..."
php artisan config:clear 2>/dev/null || echo "⚠️ Config clear failed"
php artisan route:clear 2>/dev/null || echo "⚠️ Route clear failed"
php artisan view:clear 2>/dev/null || echo "⚠️ View clear failed"

# Cache config for production (optional, skip if fails)
if [ "$APP_ENV" = "production" ]; then
    echo "⚡ Optimizing for production..."
    php artisan config:cache 2>/dev/null || echo "⚠️ Config cache skipped"
    php artisan route:cache 2>/dev/null || echo "⚠️ Route cache skipped"
fi

echo "🚀 Starting Laravel server..."
echo "📍 Server will be available at: http://0.0.0.0:$PORT"

# Start the server
exec php artisan serve --host=0.0.0.0 --port=$PORT
