## ADDED Requirements

### Requirement: Book records can be managed
The system SHALL allow users to view, create, edit, and delete books through the Blade interface.

#### Scenario: User views paginated books
- **WHEN** the user opens the book list page
- **THEN** the system displays books with title, publication year, ISBN, author, copy count, and pagination controls

#### Scenario: User creates a valid book
- **WHEN** the user submits the book creation form with valid data
- **THEN** the system saves the book, links it to the selected author, and shows a success message

#### Scenario: User edits a valid book
- **WHEN** the user submits the book edit form with valid changes
- **THEN** the system updates the book and shows a success message

#### Scenario: User deletes a deletable book
- **WHEN** the user confirms deletion of a book that has no loans
- **THEN** the system deletes the book and returns the user to the list with a success message

### Requirement: Book input is validated
The system MUST validate user input when creating and editing a book and display errors near the relevant fields.

#### Scenario: Required book fields are missing
- **WHEN** the user submits the book form without a title, author, publication year, ISBN, or copy count
- **THEN** the system does not save the changes and displays validation errors

#### Scenario: Book values are outside valid ranges
- **WHEN** the user submits a future publication year or a copy count lower than 1
- **THEN** the system rejects the data and displays a clear error message

#### Scenario: ISBN duplicates another book
- **WHEN** the user creates a book with an ISBN that already exists on another book
- **THEN** the system rejects the data and reports that ISBN must be unique

#### Scenario: Existing book keeps its ISBN during edit
- **WHEN** the user edits a book without changing its ISBN
- **THEN** the system accepts the form if the other fields are valid

### Requirement: Book seed data supports pagination
The system SHALL include meaningful test books in seed data in a quantity sufficient to verify pagination.

#### Scenario: Database is seeded
- **WHEN** the developer runs the test data seeding command
- **THEN** the database contains a set of different books with realistic titles, years, ISBNs, authors, and copy counts

### Requirement: Book deletion preserves loan consistency
The system MUST not allow a book to be deleted if loan records exist for it.

#### Scenario: User tries to delete a loaned book
- **WHEN** the user tries to delete a book that has at least one loan
- **THEN** the system keeps the book in the database and shows a message that all copies must be returned first
