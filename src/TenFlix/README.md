## Quickstart

1) docker compose up -d --build
2) copy TenFlix/.env.example TenFlix/.env
3) docker compose exec app composer install --no-interaction --prefer-dist --optimize-autoloader
4) docker compose exec app php artisan key:generate
5) docker compose exec app php artisan migrate   # if needed
6) open http://localhost:8080
