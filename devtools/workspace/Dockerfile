FROM php:8.0-cli


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


# NodeJS
RUN	apt-get update && apt-get install -y gnupg \
	&& curl -sL https://deb.nodesource.com/setup_14.x | bash - \
	&& apt-get install -y nodejs \

# Composer
RUN	apt-get update && apt-get install -y unzip \
	&& curl -sS https://getcomposer.org/installer -o composer-setup.php \
	&& HASH=`curl -sS https://composer.github.io/installer.sig` \
    && php -r "if (hash_file('SHA384', 'composer-setup.php') === '$HASH') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www
