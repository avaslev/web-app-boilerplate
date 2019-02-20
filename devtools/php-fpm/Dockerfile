FROM php:7.2-fpm

# PHP Extentions
# Postgre PDO
RUN apt-get update && apt-get install -y \
			librabbitmq-dev \
            libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install -j$(nproc) \
    	pdo \
    	pdo_pgsql \
    	pgsql \
    	bcmath \
    	sockets \
    && pecl install amqp \
	&& docker-php-ext-enable amqp


WORKDIR /var/www
