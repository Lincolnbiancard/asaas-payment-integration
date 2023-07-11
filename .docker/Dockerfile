# ===== Stage 1: Build the application =====
FROM php:8.1-fpm AS php

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy existing application directory contents
COPY . /var/www

# Install dependencies with composer
RUN composer install

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]



# ======================== Stage 2: Setup the Nginx ====================================
FROM nginx:1.21-alpine AS nginx

# Copy the Nginx configuration file
COPY .docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

# Remove default nginx index page
RUN rm -rf /usr/share/nginx/html/*

# Copy the build stage into Nginx
COPY --from=php /var/www /var/www

# Set working directory
WORKDIR /var/www

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
