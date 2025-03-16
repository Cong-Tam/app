# php
FROM php:8.1-fpm

ENV TZ="UTC"

COPY ./php.ini /usr/local/etc/php/php.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
    apt-get -y install \
    git \
    zip \
    unzip \
    vim \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apt-get -y install mariadb-client \
    && docker-php-ext-install pdo_mysql zip \
    && docker-php-ext-configure gd --with-freetype \
    && docker-php-ext-install -j$(nproc) gd 

RUN apt-get update && \
    apt-get install -y \
    libpng-dev 
RUN apt-get install -y imagemagick \
    libmagickwand-dev 

RUN cd /tmp && \
    git clone https://github.com/Imagick/imagick && \
    cd imagick && \
    git switch master && \
    git checkout 28f2704 && \
    phpize && \
    ./configure && \
    make && \
    make install && \
    rm -r /tmp/imagick
RUN docker-php-ext-enable imagick

RUN mkdir -p /etc/ImageMagick-6 && \
    echo '<?xml version="1.0" encoding="UTF-8"?>' > /etc/ImageMagick-6/policy.xml && \
    echo '<!DOCTYPE policy SYSTEM "policy.dtd">' >> /etc/ImageMagick-6/policy.xml && \
    echo '<policy domain="coder" rights="read|write" pattern="PDF"/>' >> /etc/ImageMagick-6/policy.xml

WORKDIR /var/www/html