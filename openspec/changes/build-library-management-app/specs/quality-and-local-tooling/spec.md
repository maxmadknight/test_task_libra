## ADDED Requirements

### Requirement: Local runtime is wrapped in Docker
The system SHALL provide a Docker-based local runtime for the test task using PostgreSQL as the database.

#### Scenario: Developer starts the Docker runtime
- **WHEN** the developer starts the provided Docker configuration
- **THEN** the application service and PostgreSQL database service start with the environment required to run the Laravel application locally

#### Scenario: Developer resets local data
- **WHEN** the developer runs the documented migration and seeding flow inside the Docker runtime
- **THEN** the database schema is recreated and meaningful seed data is loaded successfully

### Requirement: Fast local startup script is provided
The repository SHALL include an executable shell script for fast local startup.

#### Scenario: Developer runs the startup script
- **WHEN** the developer runs `./run-local.sh` from the repository root
- **THEN** the script starts the Docker runtime, prepares required application files when needed, runs migrations and seeders, and prints the local application URL

#### Scenario: Startup step fails
- **WHEN** a required startup command fails
- **THEN** the script exits with a non-zero status and leaves enough command output to identify the failing step

### Requirement: Latest compatible packages are used
The project MUST use latest stable packages that are compatible with Laravel 13.

#### Scenario: Dependencies are selected
- **WHEN** the developer installs Laravel and development tooling
- **THEN** the selected package versions are checked against the current package repository metadata and remain compatible with Laravel 13

### Requirement: Required behavior is covered by Pest automated tests
The system MUST include Pest automated tests for the main user-facing flows and business rules.

#### Scenario: Test suite is executed
- **WHEN** the developer runs the documented test command
- **THEN** Pest tests verify book CRUD, author CRUD, loan creation, unavailable-copy rejection, loan return, filtering, pagination, and validation error handling

#### Scenario: Business rule regresses
- **WHEN** a change allows loan creation for a book with no available copies
- **THEN** the Pest tests fail

### Requirement: Laravel Dusk browser tests are required
The project MUST include Laravel Dusk browser tests for the interactive Blade UI.

#### Scenario: Dusk is installed
- **WHEN** the developer installs project dependencies
- **THEN** `laravel/dusk` is available as a development dependency and the project contains the standard Dusk test structure

#### Scenario: Browser tests are executed
- **WHEN** the developer runs `php artisan dusk`
- **THEN** browser tests verify the issue-book modal, return confirmation, author book expand/collapse behavior, and a responsive navigation or list-page smoke flow

#### Scenario: Dusk runs in the local Docker runtime
- **WHEN** the developer runs the documented Dusk command in the Docker-based local environment
- **THEN** the browser tests run with the required browser and driver dependencies available

### Requirement: PHPStan validation is required
The project MUST include PHPStan validation through Larastan for the Laravel codebase.

#### Scenario: Static analysis is executed
- **WHEN** the developer runs the documented Larastan/PHPStan command
- **THEN** Laravel-aware static analysis completes successfully for the application code at the configured level

### Requirement: Laravel Pint validation is required
The project MUST include Laravel Pint formatting validation.

#### Scenario: Formatting validation is executed
- **WHEN** the developer runs the documented Pint command
- **THEN** Pint validates the code style without reporting required formatting changes

### Requirement: Laravel best-practice flow is followed
The implementation MUST follow conventional Laravel best practices for this scope.

#### Scenario: Request data is handled
- **WHEN** create or update actions receive user input
- **THEN** validation is handled through form request classes or an equivalently conventional Laravel validation boundary

#### Scenario: Domain relationships are used
- **WHEN** controllers or views need author, book, or loan data
- **THEN** they use Eloquent relationships, eager loading where appropriate, and query scopes/helpers instead of duplicating relationship logic in Blade templates

#### Scenario: Controllers remain maintainable
- **WHEN** controllers implement CRUD and loan workflows
- **THEN** they remain focused on HTTP orchestration and delegate validation, relationships, and reusable business calculations to the appropriate Laravel classes
