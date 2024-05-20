FROM php:8.2-apache

WORKDIR /var/www/html

USER root

COPY . .

RUN apt-get update && apt-get install -y \
    libmariadb-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    && docker-php-ext-install mysqli pdo pdo_mysql gd \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN scripts/setup.sh

EXPOSE 80