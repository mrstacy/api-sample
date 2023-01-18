FROM php:8.2-fpm

WORKDIR /app

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install additional packages as needed
RUN apt-get update \
    && apt-get -y --no-install-recommends install \
    default-mysql-client \
    git \
    nano \
    zip \
    && docker-php-ext-install pdo pdo_mysql
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN mkdir /app/var; chmod 777 /app/var

RUN rm -rf /var/www/html; ln -s /app/public /var/www/html

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint
CMD docker-entrypoint; php-fpm -O

