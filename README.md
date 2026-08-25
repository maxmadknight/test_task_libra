# Library Manager

Laravel 13 test task for managing authors, books, and book loans.

## Stack

- Laravel 13 / PHP 8.5
- PostgreSQL
- Blade
- Vite with npm-managed Bootstrap and SCSS
- Custom JavaScript actions
- Pest for feature/unit tests
- Laravel Dusk for browser tests
- Larastan/PHPStan and Laravel Pint

## Fast Local Start

```bash
./run-local.sh
```

The script builds Docker services, prepares `.env`, installs Composer and npm dependencies, runs migrations and seeders, builds assets, and prints the local URL.

Open:

```text
http://localhost:8080
```

## Manual Docker Commands

```bash
docker compose up -d --build
docker compose exec app composer install
docker compose exec app npm install
docker compose exec app php artisan key:generate --force
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app npm run build
docker compose exec -d app php artisan serve --host=0.0.0.0 --port=8000
```

## Quality Gates

```bash
docker compose exec app vendor/bin/pest
docker compose exec app sh -lc 'APP_URL=http://host.docker.internal:8080 php artisan dusk'
docker compose exec app vendor/bin/phpstan analyse --memory-limit=512M
docker compose exec app vendor/bin/pint --test
```

Local host equivalents work when PHP, PostgreSQL, Node, and browser dependencies are installed.

## Useful Commands

```bash
php artisan route:list
php artisan migrate:fresh --seed
npm run dev
npm run build
vendor/bin/pint
```
