FROM php:7.4-fpm-alpine

RUN apk update && apk add autoconf g++ make && pecl install xdebug && rm -rf /tmp/pear && docker-php-ext-enable xdebug

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

COPY ./common/php-fpm/conf.d /usr/local/etc/php/conf.d
COPY ./development/php-ini/conf.d /usr/local/etc/php/conf.d

WORKDIR /app