FROM php:7.4-apache

WORKDIR /var/www/html

RUN a2enmod rewrite

RUN apt-get update -y && apt-get install -y libicu-dev unzip zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install gettext intl pdo_mysql


