# Product Context

## Problem

The repository needs to show an employer that the author can implement a small business web application without unnecessary architecture, while still delivering clean structure, tests, CI, and reproducible local setup.

## Users

- A test-task reviewer who needs to quickly evaluate code, UI, tests, and local startup.
- A developer or agent continuing work in the repository who needs to understand the scope quickly.

## Desired Experience

- The first screen leads to the books list.
- Navigation between `Books`, `Authors`, and `Book loans` is obvious.
- Forms show validation errors and success/error messages.
- Tables are scannable and paginated.
- Dropdowns for selecting authors or books are searchable through `Tom Select`.
- From a book row, the user can open the related author page.
- On the author edit page, the user can see related books and whether they have been loaned.

## Key Workflows

- Add, edit, or delete an author when the author has no books.
- Add, edit, or delete a book when the book has no loans.
- Filter books by text, author, availability, and publication year.
- Issue a book to a reader through a modal when a copy is available.
- Return a book by deleting the loan record.
- Filter loans by reader, book title, loan date, and status.

## Product Trade-offs

- Loan return is implemented by deleting the record because this is sufficient for the test assignment.
- Authentication and authorization are absent because they are explicitly out of scope.
- Loan status is stored in the database for simple filtering, while domain values are centralized in an enum.
- The UI remains server-rendered through `Blade`; JavaScript is only used for local interactions.

Current state and next steps are tracked in [activeContext.md](./activeContext.md).
