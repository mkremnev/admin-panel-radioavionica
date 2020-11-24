###### Builder ######
FROM php:7.4-fpm-alpine AS builder

RUN apk update && apk add unzip

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache

WORKDIR /app

COPY ./public/composer.json ./public/composer.lock ./

RUN composer install --no-dev --prefer-dist --no-progress --no-suggest --optimize-autoloader --no-scripts && rm -rf /root/.composer/cache

###### CLI ######
FROM php:7.4-fpm-alpine

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY ./docker/common/php-fpm/conf.d /usr/local/etc/php/conf.d
COPY ./docker/production/php-ini/conf.d /usr/local/etc/php/conf.d

WORKDIR /app

COPY ./ ./