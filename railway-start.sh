#!/bin/bash

# Function to check database connectivity
check_database() {
    local max_attempts=30
    local attempt=1
    
    echo "Checking database environment variables:"
    echo "PGHOST: ${PGHOST:-'not set'}"
    echo "PGPORT: ${PGPORT:-'not set'}"
    echo "PGDATABASE: ${PGDATABASE:-'not set'}"
    echo "PGUSER: ${PGUSER:-'not set'}"
    echo "DATABASE_URL: ${DATABASE_URL:-'not set'}"
    
    while [ $attempt -le $max_attempts ]; do
        echo "Attempt $attempt: Checking database connectivity..."
        
        # Try to connect to database
        if php -r "
            try {
                if (!empty('${DATABASE_URL}')) {
                    \$pdo = new PDO('${DATABASE_URL}');
                } else {
                    \$pdo = new PDO('pgsql:host=${PGHOST};port=${PGPORT};dbname=${PGDATABASE}', '${PGUSER}', '${PGPASSWORD}');
                }
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

echo "=== Starting Laravel Application ==="
echo "Environment: ${APP_ENV:-'not set'}"
echo "Debug: ${APP_DEBUG:-'not set'}"
echo "URL: ${APP_URL:-'not set'}"
echo "Port: ${PORT:-'not set'}"

# Ensure we have production environment
if [ ! -f ".env" ]; then
    echo "No .env file found, copying from .env.example..."
    cp .env.example .env
fi

# Check Laravel setup
echo "Checking Laravel files..."
if [ ! -f "artisan" ]; then
    echo "❌ artisan file not found!"
    exit 1
fi

if [ ! -f "vendor/autoload.php" ]; then
    echo "❌ Composer vendor directory not found!"
    exit 1
fi

# Test basic PHP functionality
echo "Testing PHP setup..."
php --version
if ! php artisan --version; then
    echo "❌ Laravel artisan not working!"
    exit 1
fi

echo "✅ Laravel artisan working"

# Check if we're in production and database is required
if [ "$APP_ENV" = "production" ]; then
    echo "Production environment detected, checking database..."
    
    if check_database; then
        echo "Running database migrations..."
        if php artisan migrate --force; then
            echo "✅ Migrations completed"
        else
            echo "⚠️ Migration failed, but continuing..."
        fi
        
        # Run any seeders if needed (optional)
        # php artisan db:seed --force
    else
        echo "⚠️ Database check failed, but continuing to start server..."
    fi
fi

# Clear any cached config and cache fresh ones
echo "Optimizing application for production..."
php artisan config:clear
if php artisan config:cache; then
    echo "✅ Config cached"
else
    echo "⚠️ Config cache failed, continuing..."
fi

if php artisan route:cache; then
    echo "✅ Routes cached"
else
    echo "⚠️ Route cache failed, continuing..."
fi

if php artisan view:cache; then
    echo "✅ Views cached"
else
    echo "⚠️ View cache failed, continuing..."
fi

echo "Starting web server on 0.0.0.0:$PORT..."
echo "You can access the application at your Railway domain"

# Start server with error logging
exec php artisan serve --host=0.0.0.0 --port=$PORT --verbose
