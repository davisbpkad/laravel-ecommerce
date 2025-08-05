#!/bin/bash

# Wait for database to be available
echo "Waiting for database to be ready..."
while ! pg_isready -h $PGHOST -p $PGPORT -U $PGUSER > /dev/null 2>&1; do
  echo "Database not ready, waiting 2 seconds..."
  sleep 2
done

echo "Database is ready!"

# Run migrations
echo "Running database migrations..."
php artisan migrate --force

# Clear and cache config for production
echo "Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the web server
echo "Starting web server..."
php artisan serve --host=0.0.0.0 --port=$PORT
