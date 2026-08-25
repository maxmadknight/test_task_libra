# Library Manager

[![Code Quality And Tests](https://github.com/maxmadknight/test_task_libra/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/maxmadknight/test_task_libra/actions/workflows/ci.yml)

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

Run Pest and Dusk serially because both reset the same PostgreSQL test database.

## GitHub Actions

The workflow in `.github/workflows/ci.yml` runs on pull requests and pushes to `main`, `master`, and `develop`.

It runs Composer validation, npm build, route sanity checks, Laravel Pint, Larastan/PHPStan, Pest, Laravel Dusk, and OpenSpec validation against PostgreSQL. OpenSpec validation uses `npx -y @fission-ai/openspec@latest`.

## Useful Commands

```bash
php artisan route:list
php artisan migrate:fresh --seed
npm run dev
npm run build
vendor/bin/pint
```
