#!/bin/bash
set -e

echo "=== Railway Laravel Start ==="

# Validate and set PORT
if [ -z "$PORT" ] || ! [[ "$PORT" =~ ^[0-9]+$ ]] || [ "$PORT" -lt 1 ] || [ "$PORT" -gt 65535 ]; then
    echo "⚠️ Invalid or missing PORT variable, using default 8080"
    PORT=8080
else
    echo "✅ Using PORT: $PORT"
fi

echo "🚀 Starting Laravel server on 0.0.0.0:$PORT"

# Start Laravel
exec php artisan serve --host=0.0.0.0 --port=$PORT
