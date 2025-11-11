FROM php:8.2-cli

RUN apt-get update && apt-get install -y git zip unzip curl libpq-dev \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY TenFlix/ /var/www/html
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh

RUN docker-php-ext-install pdo_pgsql \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && composer install --no-interaction --prefer-dist --optimize-autoloader \
 && cp .env.example .env \
 && php artisan key:generate --ansi

RUN chmod +x /usr/local/bin/docker-entrypoint.sh


EXPOSE 8000

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
