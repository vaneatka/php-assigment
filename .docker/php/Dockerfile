FROM php:7.3-alpine

WORKDIR /app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

RUN apk add --no-cache $PHPIZE_DEPS \
                    graphviz \
                    ttf-freefont \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-install pdo \
    && docker-php-ext-install pdo_mysql


COPY xdebug.ini  /usr/local/etc/php/conf.d/xdebug.ini


CMD ["php", "-S", "0.0.0.0:8000", "-t", "/app/public", "/app/public/index.php"]
