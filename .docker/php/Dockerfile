FROM php:7.2-alpine

WORKDIR /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug-2.6.1 \
    && docker-php-ext-enable xdebug

COPY xdebug.ini  /usr/local/etc/php/conf.d/xdebug.ini

EXPOSE 8000
EXPOSE 9000

CMD ["php", "-S", "0.0.0.0:8000", "-t", "/app/public", "/app/public/index.php"]
