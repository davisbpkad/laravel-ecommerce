#!/bin/bash

# Function to check database connectivity
check_database() {
    local max_attempts=30
    local attempt=1
    
    while [ $attempt -le $max_attempts ]; do
        echo "Attempt $attempt: Checking database connectivity..."
        
        if [ -n "$DATABASE_URL" ]; then
            # Try using DATABASE_URL if available
            php artisan tinker --execute="DB::connection()->getPdo();" 2>/dev/null
        else
            # Try using individual environment variables
            php artisan tinker --execute="DB::connection()->getPdo();" 2>/dev/null
        fi
        
        if [ $? -eq 0 ]; then
            echo "Database connection successful!"
            return 0
        fi
        
        echo "Database not ready, waiting 5 seconds... (attempt $attempt/$max_attempts)"
        sleep 5
        ((attempt++))
    done
    
    echo "Failed to connect to database after $max_attempts attempts"
    return 1
}

echo "Starting Laravel application..."

# Check if we're in production and database is required
if [ "$APP_ENV" = "production" ]; then
    echo "Production environment detected, checking database..."
    
    if check_database; then
        echo "Running database migrations..."
        php artisan migrate --force
        
        if [ $? -ne 0 ]; then
            echo "Migration failed, but continuing..."
        fi
    else
        echo "Database check failed, but continuing to start server..."
    fi
fi

# Clear any cached config and cache fresh ones
echo "Optimizing application for production..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting web server on port $PORT..."
exec php artisan serve --host=0.0.0.0 --port=$PORT
