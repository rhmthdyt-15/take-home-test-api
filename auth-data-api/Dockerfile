FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libssl-dev \
    libbrotli-dev \
    pkg-config \
    gcc \
    g++ \
    make

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Swoole
RUN pecl channel-update pecl.php.net && \
    pecl install swoole && \
    docker-php-ext-enable swoole

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/auth-data-api

# Copy existing application directory contents
COPY . /var/www/auth-data-api

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/auth-data-api

# Change current user to www-data
USER www-data
