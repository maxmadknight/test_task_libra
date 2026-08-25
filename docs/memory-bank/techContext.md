# Technical Context

## Stack

- `Laravel 13` on `PHP 8.5` in the Docker image.
- `PostgreSQL 18-alpine` for local development and CI.
- `Blade` templates.
- `Vite`, `SCSS`, `Bootstrap`, `Tom Select`, and custom JavaScript actions.
- `Pest` for feature/unit tests.
- `Laravel Dusk` for browser tests.
- `Larastan/PHPStan` for static analysis.
- `Laravel Pint` for formatting.

## Local Startup

Primary path:

```bash
./run-local.sh
```

The script starts containers, prepares `.env`, installs dependencies, generates the app key, runs migrations/seeders, builds assets, and starts `php artisan serve` at `http://localhost:8080`.

## Important Commands

```bash
make run
make precommit
make quality
make test
make dusk
make stan
make pint
```

Low-level equivalents:

```bash
docker compose exec app vendor/bin/pest
docker compose exec app sh -lc 'APP_URL=http://host.docker.internal:8080 php artisan dusk'
docker compose exec app vendor/bin/phpstan analyse --memory-limit=512M
docker compose exec app vendor/bin/pint --test
docker compose exec app npm run build
docker compose exec app php artisan route:list --except-vendor
```

Run `Pest` and `Dusk` serially, not in parallel.

## Docker

- `compose.yaml` has services `app`, `postgres`, and `selenium`.
- `app` mounts the repo, composer cache, and named volume `node-modules`.
- The `node-modules` named volume prevents the Linux container from using host-native npm optional dependencies.
- `selenium/standalone-chromium` is used for `Dusk`.

## CI

Workflow: `.github/workflows/ci.yml`.

It runs on pull requests and pushes to `main`, `master`, and `develop`. There is one job, `Code Quality And Tests`, which runs Composer validation, npm build, route sanity check, `Pint`, `Larastan/PHPStan`, `Pest`, `Dusk`, and `OpenSpec` validation.

Docker image publishing was intentionally removed because this is a test project with no deployment target.

## OpenSpec

Change artifacts live in `openspec/changes/build-library-management-app/`.

CI validation command:

```bash
npx -y @fission-ai/openspec@latest validate build-library-management-app --strict
```

`OpenSpec` is the change-scoped source of requirements, while **Memory Bank** stores the durable summary.
