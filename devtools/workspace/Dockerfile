FROM php:7.2-cli


# PHP Extentions
# Postgre PDO
RUN apt-get update && apt-get install -y \
            libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) pdo pdo_pgsql pgsql


# NodeJS
RUN	apt-get update && apt-get install -y gnupg \
	&& curl -sL https://deb.nodesource.com/setup_8.x | bash - \
	&& apt-get install -y nodejs

WORKDIR /var/www
