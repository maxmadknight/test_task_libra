## 1. Project Setup

- [x] 1.1 Create or prepare a Laravel project in the repository without adding registration, authorization, roles, SPA scaffolding, or frontend state-management frameworks.
- [x] 1.2 Configure web routes, a shared Blade layout, navigation for books/authors/loans, flash messages, and npm-managed frontend packages suitable for responsive forms and tables.
- [x] 1.3 Add Vite-managed SCSS and custom JavaScript actions for modal behavior, confirmation dialogs, and author book list toggles.
- [x] 1.4 Add Docker configuration for the local test-task runtime, including application and PostgreSQL database services with appropriate volumes and environment wiring.
- [x] 1.5 Add an executable `run-local.sh` that starts the Docker environment, prepares dependencies and `.env` when needed, runs migrations and seeders, and prints the local application URL.
- [x] 1.6 Verify latest stable package versions before installation and use versions compatible with Laravel 13.

## 2. Data Model

- [x] 2.1 Create migrations for `authors`, `books`, and `book_loans` with foreign keys and appropriate constraints.
- [x] 2.2 Implement Eloquent models and relationships: author has many books, book belongs to author, book has many loans, loan belongs to book.
- [x] 2.3 Add model helpers or query scopes for available copy count, active/overdue loan filtering, and loan search filters.
- [x] 2.4 Create factories and seeders with meaningful authors, books, and loans in quantities sufficient to verify pagination.

## 3. Book Catalog

- [x] 3.1 Implement book index with author data, available fields, pagination, and preserved UI feedback.
- [x] 3.2 Implement book create/edit forms with author selection and old-input/error rendering.
- [x] 3.3 Implement book store/update using form request validation for title, publication year, ISBN uniqueness, author existence, and copies count.
- [x] 3.4 Implement book deletion with confirmation and server-side prevention when the book has loans.

## 4. Author Catalog

- [x] 4.1 Implement author index with pagination, book counts, and eagerly loaded book summaries for expandable lists.
- [x] 4.2 Implement author create/edit forms with old-input/error rendering.
- [x] 4.3 Implement author store/update using form request validation for first name and last name.
- [x] 4.4 Implement author deletion with confirmation and server-side prevention when the author has books.
- [x] 4.5 Add custom JavaScript behavior to expand and collapse each author's book list on the same page.

## 5. Book Loans

- [x] 5.1 Implement loans index with paginated loan rows showing book, reader name, loan date, due date, and status.
- [x] 5.2 Implement filter form for reader name, book title, loan date, and status with pagination preserving query parameters.
- [x] 5.3 Implement "Issue book" button and modal form with book selection, reader name, and due date.
- [x] 5.4 Implement loan creation validation, including required fields, valid due date, book existence, and available copy check.
- [x] 5.5 Implement loan return by confirmed deletion of the loan record and success/error feedback.
- [x] 5.6 Ensure unavailable books cannot be loaned and the UI communicates current book availability.

## 6. UI and Documentation

- [x] 6.1 Make list pages, forms, modal, alerts, buttons, and pagination responsive across mobile and desktop widths.
- [x] 6.2 Ensure validation errors and success messages are consistently displayed for all user-facing forms and actions.
- [x] 6.3 Write `README.md` with environment requirements, Docker/PostgreSQL setup, `run-local.sh` usage, `.env` setup, dependency install, migrations, seed command, application URL, Pest tests, Laravel Dusk, Larastan/PHPStan, Laravel Pint, and useful local commands.

## 7. Quality Gates

- [x] 7.1 Install and configure Pest with the Laravel plugin, then add feature/unit tests covering book CRUD, author CRUD, loan creation, unavailable-copy rejection, loan return, filtering, pagination, and validation errors.
- [x] 7.2 Install and configure Laravel Dusk with browser tests for the issue-book modal, return confirmation, author book expand/collapse behavior, and at least one responsive navigation/list-page smoke flow.
- [x] 7.3 Ensure the Docker runtime supports running Laravel Dusk locally and document the exact `php artisan dusk` command.
- [x] 7.4 Configure PHPStan through Larastan at a meaningful level for the Laravel codebase and document the exact command.
- [x] 7.5 Configure Laravel Pint and document the exact format/check command.
- [x] 7.6 Keep implementation aligned with Laravel best practices: form requests, route model binding where appropriate, Eloquent relationships/scopes, factories/seeders, resource controllers, and no business logic in Blade templates.

## 8. Verification

- [x] 8.1 Run the Docker-based local startup path through `run-local.sh` from a clean checkout state.
- [x] 8.2 Run migrations and seeders locally from a clean database.
- [x] 8.3 Manually verify book CRUD, author CRUD, expandable author books, loan creation, unavailable-copy rejection, loan return, filtering, and pagination.
- [x] 8.4 Run the full Pest automated test suite.
- [x] 8.5 Run Laravel Dusk browser tests.
- [x] 8.6 Run Larastan/PHPStan validation.
- [x] 8.7 Run Laravel Pint validation.
- [x] 8.8 Run available framework checks such as route listing and Laravel cache/config sanity checks.
- [x] 8.9 Validate the OpenSpec change with `openspec validate build-library-management-app --strict`.
