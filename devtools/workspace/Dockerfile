FROM php:7.2-cli


# PHP Extentions
# Postgre PDO
RUN apt-get update && apt-get install -y \
            libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql pgsql

## PHP Extentions
#RUN apt-get update && apt-get install -y \
#        libicu-dev \
#        libxml2-dev \
#        libjpeg62-turbo-dev \
#        libfreetype6-dev \
#        libpng-dev \
#        libmcrypt-dev \
#    && docker-php-ext-install -j$(nproc) pdo xml soap mbstring zip intl opcache \
#    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
#    && docker-php-ext-install -j$(nproc) gd

WORKDIR /var/www