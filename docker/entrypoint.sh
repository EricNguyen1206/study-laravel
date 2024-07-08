#!/bin/sh

# Wait for MySQL to be ready
while ! mysqladmin ping -h"$DB_HOST" --silent; do
    sleep 1
done

# Create database if it doesn't exist
mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e "CREATE DATABASE IF NOT EXISTS $DB_DATABASE CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Install npm dependencies
npm install

# Build assets
npm run dev  & # Run npm in the background

# Run Laravel commands
php artisan migrate
php artisan key:generate
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Start the Laravel development server
php artisan serve --port=8000 --host=0.0.0.0 --env=.env
