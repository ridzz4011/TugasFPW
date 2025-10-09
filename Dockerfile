# Use an official PHP image with Apache as the base image.
FROM php:8.4-apache

# Set working directory
WORKDIR /var/www/html

# Copy the rest of the application code
COPY . .

# Install system dependencies.
# Update package list and install common dependencies + PHP extensions dependencies
RUN apt-get update && apt-get install -y \
    apt-utils \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    vim \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js and npm
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y nodejs

# Verify Node.js and npm installation (optional, good for debugging)
RUN node -v
RUN npm -v

# Install PHP extensions.
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip bcmath

# Install Composer globally.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents (optimize for caching)
# First copy only composer files
COPY composer.json composer.lock ./
# Install dependencies without dev packages, optimized autoloader
RUN composer install --no-interaction --no-dev --optimize-autoloader --no-scripts

# Set permissions for Laravel storage and cache
# Ensure the apache user (www-data by default) can write to these directories
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Configure Apache
# Enable Apache rewrite module
RUN a2enmod rewrite

# Set the Apache document root to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

ENV CHOKIDAR_USEPOLLING=true

# Copy custom Apache virtual host configuration
COPY ./docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Update the document root setting in the main Apache config (needed by some versions)
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/sites-available/*.conf

# Expose port 80
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
