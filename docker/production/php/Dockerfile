# COMPOSER
FROM composer:latest as composer

FROM php:8.2-fpm as php


# Arguments defined in docker-compose.yml
ARG user
ARG uid

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
    libpq-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql pgsql mbstring exif pcntl bcmath gd zip

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pgsql pdo_pgsql \
    && docker-php-ext-enable pdo pgsql pdo_pgsql

RUN pecl install -o -f redis \
    && docker-php-ext-enable redis \
    && rm -rf /tmp/pear

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*


# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

#RUN /usr/bin/composer install --no-ansi --no-scripts --no-dev --no-interaction --no-progress --optimize-autoloader

CMD ["php-fpm"]

