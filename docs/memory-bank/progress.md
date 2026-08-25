# Прогрес

## Готово

- `Laravel 13` застосунок створений і працює як library manager.
- CRUD для authors і books реалізований.
- Book loans реалізовані з issue modal, filters, pagination і return через delete.
- Books page має search, filters і searchable author dropdown.
- Author edit page показує related books і loan status.
- Controllers переведені на one route - one invokable controller.
- Requests згруповані за manipulated entity і підключені до всіх controller actions.
- Loan statuses централізовані в enum `LoanStatus`.
- Docker runtime з `PostgreSQL` і `Selenium` налаштований.
- `run-local.sh` запускає локальне середовище.
- `Makefile` дає shortcuts для локальної розробки і `precommit`.
- CI виконує тільки quality pipeline без Docker image publishing.
- `README.md` має CI badge для `Code Quality And Tests`.
- `OpenSpec` task list для `build-library-management-app` позначений виконаним.

## In Progress

- Ініціалізовано **Memory Bank** для repo-local durable context.

## Залишилось

- За потреби архівувати або оновити `openspec/changes/build-library-management-app`, бо реалізація вже пішла далі за початковий design у частині controller structure і enum.
- Після наступних code changes оновити **Memory Bank**, якщо змінюються scope, architecture або tooling.
- За потреби додати нові `make` targets, якщо з'являться нові quality gates.

## Відомі Особливості

- `Pest` і `Dusk` не запускати паралельно через shared test database.
- `authors.show`, `books.show`, `loans.show`, `loans.create`, `loans.edit`, `loans.update` є redirect-style routes, але все одно мають окремі invokable controllers і requests.
- App не призначений для production deployment.
- `make precommit` є рекомендованою локальною перевіркою перед commit.

## Остання Перевірена Якість

Нещодавно проходили:

- `vendor/bin/pest`
- `php artisan dusk`
- `vendor/bin/phpstan analyse --memory-limit=512M`
- `vendor/bin/pint --test`

Актуальні команди дивись у [techContext.md](./techContext.md).
