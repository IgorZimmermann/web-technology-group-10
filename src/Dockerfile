FROM php:8.3-fpm-alpine

# adds important alpine packages such as git, curl, PostgreSQL PHP

RUN apk add --no-cache git curl libpq-dev && docker-php-ext-install pdo pdo_pgsql

# downloads composer and puts it in /usr/local/bin/composer

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . .

# Connects to Nginx on port 9000
CMD ["php-fpm"]
