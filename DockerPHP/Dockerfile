FROM composer:2.7 as composer-deps
WORKDIR /app
RUN composer_file="$(which composer)" && cp "$composer_file" /app/composer



FROM php:8.2.15-fpm-alpine3.19 as base-build

# Use the default production configuration
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

RUN apk update && apk add --no-cache bash git ${PHPIZE_DEPS}
RUN apk add --no-cache libzip-dev zip && docker-php-ext-install zip
RUN apk add icu-dev
RUN pecl install APCu
RUN apk del ${PHPIZE_DEPS}

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install intl opcache
RUN docker-php-ext-install bcmath
RUN docker-php-ext-enable apcu

COPY DockerPHP/www.conf /usr/local/etc/php-fpm.d/www.conf



FROM base-build as dev-build

COPY --from=composer-deps /app/composer /usr/local/bin/composer
RUN chown -R www-data:www-data /var/www/html

USER www-data
WORKDIR /var/www/html

VOLUME /var/www/html
