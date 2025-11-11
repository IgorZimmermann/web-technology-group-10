#!/bin/sh
set -e

cd /var/www/html

if [ ! -f vendor/autoload.php ]; then
  echo "vendor/autoload.php not found; running composer install..."
  composer install --no-interaction --prefer-dist --optimize-autoloader
fi

if [ ! -f .env ]; then
  echo ".env not found; copying from .env.example..."
  cp .env.example .env
fi

if ! grep -q '^APP_KEY=base64' .env; then
  echo "APP_KEY missing; generating application key..."
  php artisan key:generate --ansi
fi

if [ "$#" -eq 0 ]; then
  set -- php artisan serve --host=0.0.0.0 --port=8000
fi

exec "$@"
