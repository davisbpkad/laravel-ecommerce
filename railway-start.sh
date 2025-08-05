#!/bin/bash

# Function to check database connectivity
check_database() {
    local max_attempts=30
    local attempt=1
    
    while [ $attempt -le $max_attempts ]; do
        echo "Attempt $attempt: Checking database connectivity..."
        
        # Try to connect to database
        if php -r "
            try {
                \$pdo = new PDO('pgsql:host=${PGHOST};port=${PGPORT};dbname=${PGDATABASE}', '${PGUSER}', '${PGPASSWORD}');
                echo 'Database connection successful!';
                exit(0);
            } catch (Exception \$e) {
                echo 'Database connection failed: ' . \$e->getMessage();
                exit(1);
            }
        " 2>/dev/null; then
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

# Ensure we have production environment
if [ ! -f ".env" ]; then
    echo "No .env file found, copying from .env.example..."
    cp .env.example .env
fi

# Check if we're in production and database is required
if [ "$APP_ENV" = "production" ]; then
    echo "Production environment detected, checking database..."
    
    if check_database; then
        echo "Running database migrations..."
        php artisan migrate --force
        
        if [ $? -ne 0 ]; then
            echo "Migration failed, but continuing..."
        fi
        
        # Run any seeders if needed (optional)
        # php artisan db:seed --force
    else
        echo "Database check failed, but continuing to start server..."
    fi
fi

# Clear any cached config and cache fresh ones
echo "Optimizing application for production..."
php artisan config:clear
php artisan config:cache || echo "Config cache failed, continuing..."
php artisan route:cache || echo "Route cache failed, continuing..."
php artisan view:cache || echo "View cache failed, continuing..."

echo "Starting web server on port $PORT..."
exec php artisan serve --host=0.0.0.0 --port=$PORT
