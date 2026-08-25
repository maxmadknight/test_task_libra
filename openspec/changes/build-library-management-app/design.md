## Context

The current checkout does not contain application code, so the implementation must create a compact latest-stable Laravel 13 web application for the test assignment. The main interface must be server-rendered through Blade, while custom JavaScript actions are used only for local interactivity: the modal window, confirmations, and expanding lists.

The key entities are authors, books, and book loans. An author has many books, a book belongs to one author, and a book has many active or historical loans. The assignment requires returning a book by deleting the loan record, so copy availability is calculated from `copies_count` minus the number of current loan records for the book.

## Goals / Non-Goals

**Goals:**
- Implement full CRUD for books and authors with validation and clear messages.
- Implement book issuing through a modal form, available-copy validation, and returns through confirmed loan deletion.
- Provide pagination for books, authors, and loans, plus loan filtering with query parameters preserved across pagination.
- Provide meaningful seed data sufficient for pagination verification.
- Provide a Docker-based local runtime for the test task using PostgreSQL.
- Provide a shell script that performs the common local startup path quickly.
- Cover the core user-facing and business-rule behavior with Pest automated tests, including Laravel Dusk browser coverage for interactive UI flows.
- Add PHPStan validation through Larastan and Laravel Pint formatting as required quality gates.
- Prepare a README with local setup, Docker/PostgreSQL, Pest tests, Laravel Dusk, Larastan/PHPStan, and Pint instructions.

**Non-Goals:**
- Do not implement registration, authorization, roles, or access permissions.
- Do not build an SPA or separate API-only frontend.
- Do not create production-ready CI/CD infrastructure.
- Do not introduce SPA scaffolding or frontend state-management frameworks.

## Decisions

1. Use standard Laravel MVC with Eloquent models, resource controllers, and form request classes.
   - Reason: the test evaluates organization, maintainability, and database work, and standard Laravel patterns provide a clear structure without unnecessary architecture.
   - Alternative: a service layer for every operation. It is not needed for this scope, except for a small method/query to check copy availability.

2. Store `authors`, `books`, and `book_loans` in separate tables.
   - `authors`: `first_name`, `last_name`.
   - `books`: `author_id`, `title`, `publication_year`, `isbn`, `copies_count`.
   - `book_loans`: `book_id`, `reader_name`, `loaned_at`, `due_at`, `status`.
   - Reason: this model clearly represents the relationships and allows correct filtering and available-copy counting.
   - Alternative: store the author as a string on the book. This complicates the author list with books and creates duplication.

3. Enforce copy availability on the server when a loan is created.
   - Rule: a new loan may be created only when the current loan count for the book is lower than `copies_count`.
   - For the minimal test application, request/controller validation with a repeated check before saving is sufficient; if needed, creation can be wrapped in a transaction with `lockForUpdate()` on the book row.
   - Alternative: maintain a separate `available_copies` field. It requires synchronization on every issue/return and can drift more easily from the actual data.

4. Store loan status as an enum-like string.
   - Minimal values: `active`, `overdue`.
   - `overdue` may be determined during seeding or display based on `due_at < today`; for simpler filtering, the `status` field is stored in the table.
   - Alternative: calculate status fully dynamically. This reduces stored data but complicates status filtering and seed scenarios.

5. Build the interface with a Blade layout + partials, npm-managed frontend packages, SCSS, and custom JavaScript actions.
   - Reason: the frontend must be built through the normal Laravel Vite pipeline so reviewers can inspect real project assets instead of CDN snippets.
   - Expected shape: install frontend dependencies through npm, compile assets with Vite, keep styles in SCSS, and keep local UI behavior in custom JavaScript action modules.
   - Alternative: CDN-only Bootstrap/jQuery snippets. That is not acceptable because the task explicitly requires npm packages, SCSS, and custom JavaScript actions.

6. Use latest compatible package versions before installation.
   - Reason: the task should target the current Laravel ecosystem rather than older defaults.
   - Expected shape: verify available versions before installation and use latest stable packages compatible with Laravel 13, including Pest, Pest Laravel plugin, Laravel Dusk, Larastan, Laravel Pint, and frontend npm packages.
   - Alternative: pin older versions from memory. That is not acceptable because the package ecosystem is moving and the task explicitly targets latest packages.

7. Wrap local execution in Docker Compose with PostgreSQL and expose a single fast-start shell script.
   - Reason: reviewers must be able to run the test task consistently without reconstructing PHP/database dependencies manually.
   - Expected shape: `docker-compose.yml` or `compose.yaml`, application container, PostgreSQL database container, persistent database volume, and a script such as `run-local.sh` that installs dependencies when needed, prepares `.env`, starts containers, runs migrations and seeders, and prints the local URL.
   - Alternative: only document manual PHP/Composer/database commands. That is not sufficient because the task explicitly requires a Docker instance and a fast local startup script.

8. Use Laravel best-practice flow for implementation and verification.
   - Reason: the implementation should be easy to review and maintain, not just functionally complete.
   - Expected shape: form request validation, route model binding where appropriate, resource controllers, Eloquent relationships/scopes, factories/seeders, Pest feature tests for HTTP flows, Laravel Dusk browser tests for interactive UI flows, focused Pest unit tests for business helpers when useful, PHPStan analysis through Larastan, and Laravel Pint formatting.
   - Alternative: put validation and data access directly in Blade or ad hoc scripts. That would make the test task harder to maintain and verify.

9. Add Laravel Dusk for browser-level verification.
   - Reason: the assignment includes client-side behavior such as modals, confirmations, and expand/collapse controls that are better verified through a real browser than only through HTTP feature tests.
   - Expected shape: require `laravel/dusk` as a development dependency, run `php artisan dusk:install`, keep browser tests under `tests/Browser`, and document `php artisan dusk` as the browser-test command.
   - Docker impact: the Docker setup must include or support the browser/driver dependencies required for Dusk to run locally.
   - Alternative: rely only on manual UI testing. That is not sufficient because Laravel Dusk is now part of the required quality gate.

## Risks / Trade-offs

- [Race condition while issuing the last available copy concurrently] -> Server-side validation is sufficient for the test assignment; for a stronger guarantee, loan creation should run in a transaction with `lockForUpdate()` on the book.
- [Deleting an author with books can break relationships] -> Prevent author deletion when the author has books and show a clear message.
- [Deleting a book with active loans can lose business state] -> Prevent book deletion when the book has any loans.
- [Filtering can be reset during pagination] -> Use `withQueryString()` on paginators.
- [The modal form can lose errors after redirect] -> On loan creation errors, return validation errors and a flag that reopens the modal after page reload.
- [Docker startup can hide application errors] -> The fast-start script should fail on command errors and print the exact failing step.
- [Quality tools can be skipped by reviewers] -> README and the startup/verification commands should make Pest, Dusk, Larastan/PHPStan, and Pint explicit and easy to run.
- [Dusk can be brittle in Docker when browser dependencies are incomplete] -> The Docker setup and README should make the browser runtime requirements explicit and the Dusk command reproducible.
