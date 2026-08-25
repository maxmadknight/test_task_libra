## ADDED Requirements

### Requirement: Author records can be managed
The system SHALL allow users to view, create, edit, and delete authors through the Blade interface.

#### Scenario: User views paginated authors
- **WHEN** the user opens the author list page
- **THEN** the system displays authors with first name, last name, book count, management actions, and pagination controls

#### Scenario: User creates a valid author
- **WHEN** the user submits the author creation form with a valid first name and last name
- **THEN** the system saves the author and shows a success message

#### Scenario: User edits a valid author
- **WHEN** the user submits the author edit form with valid changes
- **THEN** the system updates the author and shows a success message

#### Scenario: User deletes an author without books
- **WHEN** the user confirms deletion of an author who has no books
- **THEN** the system deletes the author and returns the user to the list with a success message

### Requirement: Author input is validated
The system MUST validate the author's first name and last name during creation and editing.

#### Scenario: Author fields are missing
- **WHEN** the user submits the author form without a first name or last name
- **THEN** the system does not save the changes and displays validation errors

#### Scenario: Author fields are too long
- **WHEN** the user submits a first name or last name that exceeds the allowed field length
- **THEN** the system rejects the data and displays a validation error

### Requirement: Author book lists can be expanded
The system SHALL display each author's book list on the authors page with the ability to expand or collapse the list without navigating to another page.

#### Scenario: User expands an author's books
- **WHEN** the user clicks the expand control next to an author
- **THEN** the system displays that author's books on the same page

#### Scenario: User collapses an author's books
- **WHEN** the user clicks the collapse control next to an open book list
- **THEN** the system hides that author's books without reloading the page

### Requirement: Author seed data supports pagination
The system SHALL include meaningful test authors in seed data in a quantity sufficient to verify pagination.

#### Scenario: Database is seeded
- **WHEN** the developer runs the test data seeding command
- **THEN** the database contains a set of different authors with realistic first names, last names, and related books

### Requirement: Author deletion preserves book consistency
The system MUST not allow an author to be deleted if at least one book is related to that author.

#### Scenario: User tries to delete an author with books
- **WHEN** the user tries to delete an author who has books
- **THEN** the system keeps the author in the database and shows a message that the books must be deleted or reassigned first
