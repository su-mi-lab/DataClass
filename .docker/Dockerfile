FROM php:7.2-fpm

ENV APP_DIR /var/opt/app

RUN apt-get update
RUN apt-get install -y zlib1g-dev
RUN docker-php-ext-install zip


RUN apt-get update \
    && apt-get install -y libpq-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR ${APP_DIR}