#!/usr/bin/env bash
set -euo pipefail

step() {
    printf '\n==> %s\n' "$1"
}

step "Starting Docker services"
docker compose up -d --build

step "Preparing environment"
docker compose exec app sh -lc 'test -f .env || cp .env.example .env'

step "Installing PHP dependencies"
docker compose exec app composer install

step "Installing frontend dependencies"
docker compose exec app npm install

step "Generating application key"
docker compose exec app php artisan key:generate --force

step "Migrating and seeding PostgreSQL"
docker compose exec app php artisan migrate:fresh --seed

step "Building frontend assets"
docker compose exec app npm run build

step "Starting Laravel development server"
docker compose exec app sh -lc 'if command -v pkill >/dev/null 2>&1; then pkill -f "[p]hp artisan serve --host=0.0.0.0 --port=8000" || true; fi'
docker compose exec -d app php artisan serve --host=0.0.0.0 --port=8000

step "Application is ready"
printf 'Open http://localhost:8080\n'
