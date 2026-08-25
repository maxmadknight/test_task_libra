# Active Context

## Current Focus

The project is currently complete for the test assignment. The active focus is keeping repo context accurate through **Memory Bank** so future changes stay aligned with scope.

## Recent Changes

- Added the CI badge to `README.md` for the `CI/CD` workflow.
- Removed `build-and-publish-image` because the app will not be deployed or used anywhere.
- Reworked controllers to one route - one invokable controller.
- Grouped requests by entity and attached a `FormRequest` to every controller action.
- Added enum `App\Enums\LoanStatus` for loan statuses.
- Author edit pages show related books and loan status.
- Book rows link from author name to the author page.
- Books page has search, filters, and searchable dropdowns through `Tom Select`.
- Added `Makefile` shortcuts, including `make precommit`.

## Current Sources Of Truth

- Scope and setup: `README.md`.
- Change-scoped requirements: `openspec/changes/build-library-management-app/`.
- Routes: `routes/web.php`.
- Entity controllers: `app/Http/Controllers/{Authors,Books,Loans}`.
- Entity requests: `app/Http/Requests/{Authors,Books,Loans}`.
- Loan statuses: `app/Enums/LoanStatus.php`.
- CI: `.github/workflows/ci.yml`.
- Local development shortcuts: `Makefile`.

## Next Steps

- After every meaningful change, update [progress.md](./progress.md) and this file.
- If an architecture decision changes, add or update an entry in [decisinLog.md](./decisinLog.md).
- If `OpenSpec` is archived, reflect that in [progress.md](./progress.md).
- Before committing code, tests, assets, or `OpenSpec` changes, run `make precommit`.

## Open Questions

- Whether to archive `openspec/changes/build-library-management-app` now that the implementation is complete.
- Whether returning books should preserve loan history instead of deleting the loan record; current scope does not require it.

## Active Risks

- Do not run `Pest` and `Dusk` in parallel in the current local setup because both reset the same test database.
- The `OpenSpec` design is partly older than the implementation: it mentions resource controllers and enum-like strings, while current code uses invokable controllers and `LoanStatus`.
