FROM php:8.2-cli

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY TenFlix/ /var/www/html

RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan key:generate --ansi

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
