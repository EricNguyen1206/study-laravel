# Use the official PHP image as a parent image
FROM php:8.1-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2.0 /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /var/www

# Install project dependencies
RUN composer install --optimize-autoloader --no-dev

EXPOSE 9000
CMD ["php-fpm"]