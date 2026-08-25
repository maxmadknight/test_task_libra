# Системні Патерни

## Архітектурний Огляд

Застосунок є server-rendered `Laravel` MVC. HTTP routes явно описані в `routes/web.php`; кожен route веде до окремого invokable controller. Business state зберігається в `PostgreSQL` через `Eloquent` models.

## Межі Компонентів

- `app/Models`: `Author`, `Book`, `BookLoan`, relationships, casts і невеликі доменні helpers/scopes.
- `app/Enums`: доменні enum values, зараз `LoanStatus`.
- `app/Http/Controllers/Authors`: one-action controllers для author routes.
- `app/Http/Controllers/Books`: one-action controllers для book routes.
- `app/Http/Controllers/Loans`: one-action controllers для loan routes.
- `app/Http/Requests/{Authors,Books,Loans}`: validation і authorization boundary для кожного action.
- `resources/views`: `Blade` templates і partials.
- `resources/js/actions`: custom UI actions.
- `resources/scss`: application styles plus imported package styles.

## Основні Потоки

### Authors

- `authors.index` показує авторів із counts і expandable book summaries.
- `authors.edit` підвантажує related books із `loans_count`.
- Author deletion заборонено, якщо існують книги цього автора.

### Books

- `books.index` підтримує search, author filter, availability filter і publication year range.
- Availability рахується через `copies_count` мінус кількість loans.
- Book deletion заборонено, якщо книга має loans.
- Book author у table є link на `authors.show`, який редіректить на `authors.edit`.

### Loans

- `loans.index` показує loans з фільтрами і status options із `LoanStatus::options()`.
- `loans.store` створює loan в transaction і використовує `lockForUpdate()` на book row.
- Якщо доступних примірників немає, користувач повертається на loans page з validation error і modal reopen flag.
- Повернення книги реалізовано видаленням `BookLoan`.

## Інваріанти

- Кожен controller action має власний `FormRequest`.
- Немає business logic у `Blade`, крім простого display branching.
- Фільтри list pages мають зберігатися через `withQueryString()`.
- Query для availability має бути сумісний з `PostgreSQL` pagination count query.
- Loan status у коді не дублюється рядками, а проходить через `LoanStatus`.
- Frontend interactivity не має перетворювати app на SPA.

Технічні команди і tooling дивись у [techContext.md](./techContext.md).
