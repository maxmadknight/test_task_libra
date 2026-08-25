## ADDED Requirements

### Requirement: Book loans are listed with pagination
The system SHALL have a dedicated paginated page for book loans.

#### Scenario: User views book loans
- **WHEN** the user opens the loans page
- **THEN** the system displays the book, reader name, loan date, due date, status, and pagination controls for each loan

### Requirement: Book can be loaned through modal form
The system SHALL allow a book loan to be created through a modal window on the loans page.

#### Scenario: User opens loan modal
- **WHEN** the user clicks the "Issue book" button
- **THEN** the system opens a modal window with a form for selecting a book, entering the reader name, and choosing the due date

#### Scenario: User creates a valid loan
- **WHEN** the user submits a valid loan form for a book with available copies
- **THEN** the system creates the loan, sets the loan date, and shows a success message

### Requirement: Loan input is validated
The system MUST validate loan form data and display errors in the modal window or near the relevant fields.

#### Scenario: Required loan fields are missing
- **WHEN** the user submits the loan form without a book, reader name, or due date
- **THEN** the system does not create a loan and displays validation errors

#### Scenario: Due date is invalid
- **WHEN** the user submits a due date earlier than the loan date
- **THEN** the system rejects the form and displays an error for the due date

### Requirement: Loan creation respects available copies
The system MUST not allow a loan to be created when all copies of the selected book are already loaned out.

#### Scenario: User tries to loan unavailable book
- **WHEN** the user submits the loan form for a book with no available copies
- **THEN** the system does not create a loan and shows a message that no copies are available

#### Scenario: Available copies are shown for selection
- **WHEN** the user opens the loan form
- **THEN** the system allows books to be selected in a way that communicates their current availability

### Requirement: Book return deletes loan after confirmation
The system SHALL return a book by deleting the loan record from the list after user confirmation.

#### Scenario: User confirms book return
- **WHEN** the user confirms deletion of the loan record
- **THEN** the system deletes the loan, the book has one more available copy again, and the user sees a success message

#### Scenario: User cancels book return
- **WHEN** the user cancels deletion confirmation for the loan record
- **THEN** the system does not delete the loan and does not change book availability

### Requirement: Loans can be filtered
The system SHALL allow loans to be filtered at minimum by reader name, book title, loan date, and status.

#### Scenario: User filters by reader name
- **WHEN** the user enters part of a reader name and applies the filter
- **THEN** the system shows only loans matching that name

#### Scenario: User filters by book title
- **WHEN** the user enters part of a book title and applies the filter
- **THEN** the system shows only loans for matching related books

#### Scenario: User filters by loan date
- **WHEN** the user selects a loan date and applies the filter
- **THEN** the system shows only loans with that loan date

#### Scenario: User filters by loan status
- **WHEN** the user selects a loan status and applies the filter
- **THEN** the system shows only loans with the selected status

#### Scenario: User paginates filtered loans
- **WHEN** the user moves to another results page after applying filters
- **THEN** the system preserves the active filtering parameters

### Requirement: Loan seed data supports pagination and edge cases
The system SHALL include meaningful loan seed data sufficient to verify pagination, filters, and unavailable books.

#### Scenario: Database is seeded with loans
- **WHEN** the developer runs the test data seeding command
- **THEN** the database contains loans with different readers, books, dates, and statuses
