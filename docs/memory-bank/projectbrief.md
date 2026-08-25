# Project Brief

## Overview

`Library Manager` is a test application for a work application. It demonstrates a small but complete `Laravel 13` web application for managing authors, books, and book loans.

This is not a real product and is not intended for deployment. The repository's main value is to show implementation quality, code structure, verification, and easy local startup.

## Goals

- Demonstrate complete CRUD for authors and books.
- Demonstrate issuing and returning books with available-copy validation.
- Provide search, filters, pagination, and clear server-rendered screens.
- Provide reproducible local startup through `Docker` and `PostgreSQL`.
- Cover core scenarios with tests, browser checks, and static quality gates.
- Keep the implementation flow close to modern `Laravel` best practices.

## Scope

In scope:

- Pages for `Books`, `Authors`, and `Book loans`.
- Relationships: an author has many books, a book belongs to an author, and a book has many loan records.
- `Blade` UI, `SCSS`, npm-managed assets, and custom JavaScript actions.
- `Pest`, `Laravel Dusk`, `Larastan/PHPStan`, and `Laravel Pint`.
- `OpenSpec` artifacts for the initial task definition.

Out of scope:

- Registration, authentication, roles, or permissions.
- SPA, API-only frontend, or a separate frontend framework.
- Production deployment, image publishing, secrets management, or long-term support.
- A full library domain model with return history after deleting a loan record.

## Constraints

- The local database is `PostgreSQL`.
- The app must start quickly through `./run-local.sh`.
- Each route uses a separate invokable controller.
- Each controller request uses a separate `FormRequest`.
- Controllers and requests are grouped by manipulated entity.
- Book loan statuses are centralized in enum `App\Enums\LoanStatus`.

## Success Criteria

- `README.md` is sufficient for local startup and verification.
- The CI badge shows the status of workflow `Code Quality And Tests`.
- Core commands pass: `Pest`, `Dusk`, `Larastan/PHPStan`, `Pint`, and asset build.
- `OpenSpec` change `build-library-management-app` is valid and marked complete.

Product context is in [productContext.md](./productContext.md), and technical context is in [techContext.md](./techContext.md).
