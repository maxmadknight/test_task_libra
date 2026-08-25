# Журнал Рішень

## 2026-08-25 - Test Project, Not Deployable Product

- Статус: accepted.
- Контекст: користувач уточнив, що це test project для work apply і застосунок ніде не буде використовуватися.
- Рішення: прибрати Docker image publishing з GitHub Actions і залишити тільки quality checks.
- Альтернативи: публікувати image в `GHCR`; відхилено, бо немає deployment target.
- Наслідки: CI має read-only package permissions і один job `Code Quality And Tests`.

## 2026-08-25 - One Route, One Controller

- Статус: accepted.
- Контекст: користувач попросив single-action controllers і структуру за manipulated entity.
- Рішення: замінити resource controllers на invokable controllers у `app/Http/Controllers/{Authors,Books,Loans}`.
- Альтернативи: залишити `Route::resource()` і multi-action controllers; відхилено через явну вимогу.
- Наслідки: `routes/web.php` має explicit route declarations, а кожен controller має тільки `__invoke`.

## 2026-08-25 - FormRequest For Every Controller Action

- Статус: accepted.
- Контекст: користувач попросив для всіх requests у controllers визначити form request class with validation.
- Рішення: створити `FormRequest` для кожного action, включно з redirect-only actions із порожніми `rules()`.
- Альтернативи: використовувати `Illuminate\Http\Request` для read-only або redirect actions; відхилено заради послідовності вимоги.
- Наслідки: requests згруповані за entity у `app/Http/Requests/{Authors,Books,Loans}`.

## 2026-08-25 - Loan Status Enum

- Статус: accepted.
- Контекст: hardcoded statuses у controller були дублюванням доменних значень.
- Рішення: додати backed enum `App\Enums\LoanStatus` із `label()`, `badgeContext()` і `options()`.
- Альтернативи: лишити model constants або рядки; відхилено через слабшу типізацію.
- Наслідки: `BookLoan.status` каститься у enum, validation використовує `Rule::enum()`.

## 2026-08-25 - PostgreSQL-safe Availability Filtering

- Статус: accepted.
- Контекст: availability filter має працювати з `PostgreSQL` і pagination count query.
- Рішення: використовувати correlated subquery замість `having` по alias `loans_count`.
- Альтернативи: фільтрувати через `havingRaw('copies_count > loans_count')`; відхилено, бо ламає count query.
- Наслідки: availability logic повторюється в `Book` scope і book index query.

## 2026-08-25 - Server-rendered UI With Targeted JavaScript

- Статус: accepted.
- Контекст: задача просила npm packages, `SCSS` і custom JavaScript actions, без SPA.
- Рішення: використовувати `Blade`, `Vite`, `SCSS`, `Bootstrap`, `Tom Select` і невеликі action modules.
- Альтернативи: CDN snippets або SPA framework; відхилено через scope і вимоги.
- Наслідки: UI простий для рев'ю, але має browser coverage через `Dusk`.

Поточні невирішені питання дивись у [activeContext.md](./activeContext.md).
