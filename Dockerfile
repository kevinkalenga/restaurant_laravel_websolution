
FROM php:8.4-cli-bookworm

# System dependencies and PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    curl \
    ca-certificates \
    libcurl4-openssl-dev \
    libxml2-dev \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libssl-dev \
    pkg-config \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        bcmath \
        curl \
        dom \
        gd \
        intl \
        mbstring \
        pdo_mysql \
        simplexml \
        xml \
        xmlwriter \
        zip \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y --no-install-recommends nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install PHP dependencies
COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader \
    --no-scripts

# Install frontend dependencies
COPY package.json package-lock.json ./

RUN npm ci

# Copy application
COPY . .

# Prepare Laravel directories
RUN mkdir -p \
    bootstrap/cache \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

# Clear cached package manifests
RUN rm -f bootstrap/cache/packages.php bootstrap/cache/services.php

# Check MongoDB extension and discover Laravel packages
RUN set -eux; \
    php -m | grep -i mongodb; \
    php artisan package:discover --ansi

# Build frontend
RUN npm run build

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
