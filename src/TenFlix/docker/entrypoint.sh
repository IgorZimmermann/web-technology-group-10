#!/usr/bin/env bash
set -euo pipefail

APP_DIR="/var/www/html"
cd "${APP_DIR}"

run_artisan () {
  php artisan "$@"
}

if [ ! -f vendor/autoload.php ]; then
  composer install --prefer-dist --no-progress --no-interaction
fi

if [ ! -f .env ]; then
  cp .env.example .env
  run_artisan key:generate --ansi
fi

if [ "${SKIP_DB_WAIT:-0}" != "1" ]; then
  echo "Waiting for database to be ready..."
  until pg_isready -h "${DB_HOST:-db}" -U "${DB_USERNAME:-movieweb}" -d "${DB_DATABASE:-movieweb}" >/dev/null 2>&1; do
    sleep 2
  done
fi

run_artisan migrate:fresh --force --no-interaction
run_artisan db:seed --force --no-interaction

if [ "${RUN_TMDB_FETCH:-1}" = "1" ]; then
  run_artisan tmdb:fetch-movies 5 || echo "TMDB fetch failed; continuing without seed."
fi

if [ "$#" -eq 0 ]; then
  set -- php artisan serve --host=0.0.0.0 --port="${APP_PORT:-8000}"
fi

exec "$@"
