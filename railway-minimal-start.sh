#!/bin/bash
echo "=== Minimal Railway Start ==="
echo "PORT: ${PORT:-8080}"
echo "APP_ENV: ${APP_ENV:-production}"

# Just start the server directly
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
