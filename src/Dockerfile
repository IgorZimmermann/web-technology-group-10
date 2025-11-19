FROM php:8.2-cli

RUN apt-get update \
 && apt-get install -y git zip unzip curl libpq-dev postgresql-client \
 && docker-php-ext-install pdo_pgsql \
 && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY TenFlix /var/www/html
COPY TenFlix/docker/entrypoint.sh /usr/local/bin/tenflix-entrypoint

RUN chmod +x /usr/local/bin/tenflix-entrypoint

EXPOSE 8000

ENTRYPOINT ["/usr/local/bin/tenflix-entrypoint"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
