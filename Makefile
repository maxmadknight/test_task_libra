DC := docker compose
APP := $(DC) exec app
DUSK_APP_URL := http://host.docker.internal:8080

.DEFAULT_GOAL := help

.PHONY: help up down restart build install composer-install npm-install env key migrate seed fresh serve run logs shell artisan composer npm pint format stan test tests dusk quality precommit openspec routes

help:
	@printf 'Available targets:\n'
	@printf '  make run              Start and prepare the full local app\n'
	@printf '  make up               Start Docker services\n'
	@printf '  make down             Stop Docker services\n'
	@printf '  make restart          Restart Docker services\n'
	@printf '  make install          Install PHP and frontend dependencies\n'
	@printf '  make fresh            Rebuild database and seed data\n'
	@printf '  make serve            Start Laravel dev server in the app container\n'
	@printf '  make pint             Check Laravel Pint formatting\n'
	@printf '  make format           Apply Laravel Pint formatting\n'
	@printf '  make stan             Run Larastan/PHPStan\n'
	@printf '  make test             Run Pest tests\n'
	@printf '  make dusk             Run Laravel Dusk browser tests\n'
	@printf '  make quality          Run non-browser quality checks\n'
	@printf '  make precommit        Run full local commit gate\n'
	@printf '  make shell            Open shell in the app container\n'

up:
	$(DC) up -d

down:
	$(DC) down

restart: down up

build:
	$(DC) up -d --build

install: composer-install npm-install

composer-install:
	$(APP) composer install

npm-install:
	$(APP) npm install

env:
	$(APP) sh -lc 'test -f .env || cp .env.example .env'

key:
	$(APP) php artisan key:generate --force

migrate:
	$(APP) php artisan migrate

seed:
	$(APP) php artisan db:seed

fresh:
	$(APP) php artisan migrate:fresh --seed

serve:
	$(APP) sh -lc 'if command -v pkill >/dev/null 2>&1; then pkill -f "[p]hp artisan serve --host=0.0.0.0 --port=8000" || true; fi'
	$(DC) exec -d app php artisan serve --host=0.0.0.0 --port=8000

run:
	./run-local.sh

logs:
	$(DC) logs -f app

shell:
	$(APP) sh

artisan:
	$(APP) php artisan $(cmd)

composer:
	$(APP) composer $(cmd)

npm:
	$(APP) npm $(cmd)

pint:
	$(APP) vendor/bin/pint --test

format:
	$(APP) vendor/bin/pint

stan:
	$(APP) vendor/bin/phpstan analyse --memory-limit=512M

test:
	$(APP) vendor/bin/pest

tests: test

dusk: serve
	$(APP) sh -lc 'APP_URL=$(DUSK_APP_URL) php artisan dusk'

routes:
	$(APP) php artisan route:list --except-vendor

openspec:
	$(APP) npx -y @fission-ai/openspec@latest validate build-library-management-app --strict

quality:
	$(APP) npm run build
	$(MAKE) routes
	$(MAKE) pint
	$(MAKE) stan
	$(MAKE) test

precommit: quality dusk openspec
