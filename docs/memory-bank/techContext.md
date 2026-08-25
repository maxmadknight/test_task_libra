# Технічний Контекст

## Stack

- `Laravel 13` на `PHP 8.5` у Docker image.
- `PostgreSQL 18-alpine` для local і CI.
- `Blade` templates.
- `Vite`, `SCSS`, `Bootstrap`, `Tom Select`, custom JavaScript actions.
- `Pest` для feature/unit tests.
- `Laravel Dusk` для browser tests.
- `Larastan/PHPStan` для static analysis.
- `Laravel Pint` для formatting.

## Локальний Запуск

Основний шлях:

```bash
./run-local.sh
```

Скрипт запускає containers, готує `.env`, ставить dependencies, генерує key, запускає migrations/seeders, збирає assets і стартує `php artisan serve` на `http://localhost:8080`.

## Важливі Команди

```bash
docker compose exec app vendor/bin/pest
docker compose exec app sh -lc 'APP_URL=http://host.docker.internal:8080 php artisan dusk'
docker compose exec app vendor/bin/phpstan analyse --memory-limit=512M
docker compose exec app vendor/bin/pint --test
docker compose exec app npm run build
docker compose exec app php artisan route:list --except-vendor
```

`Pest` і `Dusk` запускати серійно, не паралельно.

## Docker

- `compose.yaml` має services `app`, `postgres`, `selenium`.
- `app` монтує repo, composer cache і named volume `node-modules`.
- Named volume для `node_modules` потрібен, щоб Linux container не використовував host-native npm optional dependencies.
- `selenium/standalone-chromium` використовується для `Dusk`.

## CI

Workflow: `.github/workflows/ci.yml`.

Запускається на pull requests і pushes до `main`, `master`, `develop`. Є один job `Code Quality And Tests`, який виконує Composer validation, npm build, route sanity check, `Pint`, `Larastan/PHPStan`, `Pest`, `Dusk` і `OpenSpec` validation.

Docker image publish job навмисно прибраний, бо це test project і не має deployment target.

## OpenSpec

Change artifacts живуть у `openspec/changes/build-library-management-app/`.

Команда validation у CI:

```bash
npx -y @fission-ai/openspec@latest validate build-library-management-app --strict
```

`OpenSpec` є change-scoped джерелом вимог, а **Memory Bank** зберігає durable summary.
