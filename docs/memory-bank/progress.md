# Progress

## Done

- The `Laravel 13` application is built and works as a library manager.
- CRUD for authors and books is implemented.
- Book loans are implemented with an issue modal, filters, pagination, and return by delete.
- Books page has search, filters, and a searchable author dropdown.
- Author edit page shows related books and loan status.
- Controllers are split into one route - one invokable controller.
- Requests are grouped by manipulated entity and attached to all controller actions.
- Loan statuses are centralized in enum `LoanStatus`.
- Docker runtime with `PostgreSQL` and `Selenium` is configured.
- `run-local.sh` starts the local environment.
- `Makefile` provides local development shortcuts and `precommit`.
- CI runs only the quality pipeline without Docker image publishing.
- `README.md` has a CI badge for `Code Quality And Tests`.
- The `OpenSpec` task list for `build-library-management-app` is marked complete.

## In Progress

- **Memory Bank** is initialized for repo-local durable context.
- **Memory Bank** files have been converted to English.

## Remaining

- Archive or update `openspec/changes/build-library-management-app` if the change should be considered finalized, because implementation now differs from the original design around controller structure and enum usage.
- Update **Memory Bank** after future code changes that alter scope, architecture, tooling, or project status.
- Add new `make` targets if new quality gates appear.

## Known Notes

- Do not run `Pest` and `Dusk` in parallel because they share and reset the same test database.
- `authors.show`, `books.show`, `loans.show`, `loans.create`, `loans.edit`, and `loans.update` are redirect-style routes, but still have separate invokable controllers and requests.
- The app is not intended for production deployment.
- `make precommit` is the recommended local gate before committing.

## Last Verified Quality

Recently passed:

- `make precommit`
- `vendor/bin/pest`
- `php artisan dusk`
- `vendor/bin/phpstan analyse --memory-limit=512M`
- `vendor/bin/pint --test`

Current commands are listed in [techContext.md](./techContext.md).
