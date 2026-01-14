FROM php:8.3-fpm-alpine

# System deps
RUN apk add --no-cache \
    bash git unzip zip \
    icu-dev oniguruma-dev \
    libzip-dev \
    freetype-dev libjpeg-turbo-dev libpng-dev \
    mysql-client

# PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) \
    pdo_mysql mbstring intl zip gd opcache

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# (Опционально) чтобы права не бесили на Linux
RUN addgroup -g 1000 appgroup && adduser -G appgroup -g "" -u 1000 -D appuser \
 && chown -R appuser:appgroup /var/www

USER appuser
