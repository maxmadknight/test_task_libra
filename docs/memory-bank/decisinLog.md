# Decision Log

## 2026-08-25 - Test Project, Not Deployable Product

- Status: accepted.
- Context: the user clarified that this is a test project for a work application and the app will not be used anywhere.
- Decision: remove Docker image publishing from GitHub Actions and keep only quality checks.
- Alternatives considered: publish an image to `GHCR`; rejected because there is no deployment target.
- Consequences: CI has read-only package permissions and one job, `Code Quality And Tests`.

## 2026-08-25 - One Route, One Controller

- Status: accepted.
- Context: the user requested single-action controllers and structure by manipulated entity.
- Decision: replace resource controllers with invokable controllers in `app/Http/Controllers/{Authors,Books,Loans}`.
- Alternatives considered: keep `Route::resource()` and multi-action controllers; rejected because the user explicitly requested one route - one controller.
- Consequences: `routes/web.php` has explicit route declarations, and each controller has only `__invoke`.

## 2026-08-25 - FormRequest For Every Controller Action

- Status: accepted.
- Context: the user requested form request classes with validation for all requests in controllers.
- Decision: create a `FormRequest` for every action, including redirect-only actions with empty `rules()`.
- Alternatives considered: use `Illuminate\Http\Request` for read-only or redirect actions; rejected to keep the implementation consistent with the requirement.
- Consequences: requests are grouped by entity under `app/Http/Requests/{Authors,Books,Loans}`.

## 2026-08-25 - Loan Status Enum

- Status: accepted.
- Context: hardcoded statuses in a controller duplicated domain values.
- Decision: add backed enum `App\Enums\LoanStatus` with `label()`, `badgeContext()`, and `options()`.
- Alternatives considered: keep model constants or raw strings; rejected because they are less type-safe.
- Consequences: `BookLoan.status` is cast to the enum, and validation uses `Rule::enum()`.

## 2026-08-25 - PostgreSQL-safe Availability Filtering

- Status: accepted.
- Context: the availability filter must work with `PostgreSQL` and pagination count queries.
- Decision: use a correlated subquery instead of `having` on the alias `loans_count`.
- Alternatives considered: filter with `havingRaw('copies_count > loans_count')`; rejected because it breaks the count query.
- Consequences: availability logic appears in the `Book` scope and the book index query.

## 2026-08-25 - Server-rendered UI With Targeted JavaScript

- Status: accepted.
- Context: the task requested npm packages, `SCSS`, and custom JavaScript actions without an SPA.
- Decision: use `Blade`, `Vite`, `SCSS`, `Bootstrap`, `Tom Select`, and small action modules.
- Alternatives considered: CDN snippets or an SPA framework; rejected because they do not match the scope and requirements.
- Consequences: the UI stays easy to review while still having browser coverage through `Dusk`.

Current unresolved questions are tracked in [activeContext.md](./activeContext.md).
