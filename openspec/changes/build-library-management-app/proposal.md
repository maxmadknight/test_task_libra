## Why

A small web application for library management needs to be implemented as a Laravel test assignment. OpenSpec records the scope, business rules, and implementation boundaries before code is written so the core evaluated functionality is complete, verifiable, and not expanded with unnecessary features.

## What Changes

- Create a latest-stable Laravel 13 + Blade application without registration, authorization, roles, SPA architecture, or production-ready infrastructure.
- Add CRUD for books with an author, publication year, ISBN, and copy count.
- Add CRUD for authors with a list of their books on the authors page and client-side expand/collapse behavior.
- Add a book loans page with an issue modal, filters, pagination, returns by deleting loan records, and available-copy accounting.
- Add meaningful seed data for verifying pagination of books, authors, and loans.
- Wrap the test task in a local Docker setup using PostgreSQL and provide a shell script for fast local startup.
- Cover the required behavior with Pest automated tests, including Laravel Dusk browser tests, and add quality gates for PHPStan through Larastan and Laravel Pint.
- Document local setup, Docker/PostgreSQL usage, tests, Laravel Dusk, Larastan/PHPStan, and Pint in `README.md`.

## Capabilities

### New Capabilities
- `book-catalog`: book CRUD, validation, author relationship, pagination, and seed data.
- `author-catalog`: author CRUD, pagination, expandable/collapsible author book lists, and seed data.
- `book-loans`: book issue and return workflows, filtering, pagination, loan statuses, and available-copy checks.
- `local-library-delivery`: Blade interface, npm-managed frontend packages, SCSS styling, custom JavaScript actions, responsiveness, error/success feedback, and README for local setup.
- `quality-and-local-tooling`: Docker-based PostgreSQL local runtime, fast startup shell script, Pest automated tests, Laravel Dusk browser tests, PHPStan validation through Larastan, Laravel Pint formatting, latest-compatible package policy, and Laravel best-practice implementation flow.

### Modified Capabilities

None.

## Impact

- New Laravel application or adaptation of the current empty checkout into a Laravel project.
- Migrations, models, factories/seeders, controllers, form requests, Blade templates, routes, and README.
- Client-side interactivity through custom JavaScript actions for the modal, return confirmation, and author book expansion.
- npm-managed frontend packages, Vite asset compilation, and SCSS styles.
- Docker configuration with PostgreSQL, local startup shell script, Pest test suite, Laravel Dusk setup and browser tests, Larastan/PHPStan configuration, and Laravel Pint configuration or scripts.
