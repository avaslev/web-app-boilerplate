FROM nginx:alpine

MAINTAINER Mahmoud Zalt <mahmoud@zalt.me>

ADD nginx.conf /etc/nginx/

ARG PHP_UPSTREAM_CONTAINER=php-fpm
ARG PHP_UPSTREAM_PORT=9000
ARG SSE_UPSTREAM_CONTAINER=mercure

RUN adduser -u 1000 -D -S -G www-data www-data

# Set upstream conf and remove the default conf
RUN echo "upstream php-upstream { server ${PHP_UPSTREAM_CONTAINER}:${PHP_UPSTREAM_PORT}; }" > /etc/nginx/conf.d/upstream.conf && \
	echo "upstream sse { server ${SSE_UPSTREAM_CONTAINER}; }" >> /etc/nginx/conf.d/upstream.conf && \
    rm /etc/nginx/conf.d/default.conf

CMD ["nginx"]

EXPOSE 80 443
