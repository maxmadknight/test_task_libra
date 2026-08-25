# System Patterns

## Architecture Overview

The application is a server-rendered `Laravel` MVC app. HTTP routes are declared explicitly in `routes/web.php`; each route maps to a separate invokable controller. Business state is stored in `PostgreSQL` through `Eloquent` models.

## Component Boundaries

- `app/Models`: `Author`, `Book`, `BookLoan`, relationships, casts, and small domain helpers/scopes.
- `app/Enums`: domain enum values, currently `LoanStatus`.
- `app/Http/Controllers/Authors`: one-action controllers for author routes.
- `app/Http/Controllers/Books`: one-action controllers for book routes.
- `app/Http/Controllers/Loans`: one-action controllers for loan routes.
- `app/Http/Requests/{Authors,Books,Loans}`: validation and authorization boundary for each action.
- `resources/views`: `Blade` templates and partials.
- `resources/js/actions`: custom UI actions.
- `resources/scss`: application styles plus imported package styles.

## Important Flows

### Authors

- `authors.index` shows authors with counts and expandable book summaries.
- `authors.edit` loads related books with `loans_count`.
- Author deletion is blocked when the author has books.

### Books

- `books.index` supports search, author filter, availability filter, and publication year range.
- Availability is calculated as `copies_count` minus the number of loans.
- Book deletion is blocked when the book has loans.
- The book author in the table links to `authors.show`, which redirects to `authors.edit`.

### Loans

- `loans.index` shows loans with filters and status options from `LoanStatus::options()`.
- `loans.store` creates a loan in a transaction and uses `lockForUpdate()` on the book row.
- When no copies are available, the user returns to loans page with a validation error and modal reopen flag.
- Returning a book is implemented by deleting `BookLoan`.

## Invariants

- Every controller action has its own `FormRequest`.
- No business logic belongs in `Blade` beyond simple display branching.
- List-page filters must be preserved through `withQueryString()`.
- Availability queries must be compatible with `PostgreSQL` pagination count queries.
- Loan status must not be duplicated as raw strings; it goes through `LoanStatus`.
- Frontend interactivity must not turn the app into an SPA.

Tooling and commands are listed in [techContext.md](./techContext.md).
