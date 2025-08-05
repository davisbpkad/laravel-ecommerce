#!/bin/bash
set -e

echo "=== Railway Laravel Start ==="

# Debug environment
echo "DEBUG: Environment variables:"
echo "PORT value: '${PORT}'"
echo "PORT type: $(echo $PORT | wc -c) chars"

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

# Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear 2>/dev/null || echo "⚠️ Config clear skipped"

echo "🚀 Starting Laravel server on 0.0.0.0:$PORT"

# Start Laravel
exec php artisan serve --host=0.0.0.0 --port=$PORT
