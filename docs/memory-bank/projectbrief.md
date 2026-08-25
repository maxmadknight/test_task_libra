# Короткий Опис Проєкту

## Огляд

`Library Manager` є тестовим застосунком для подачі на роботу. Він демонструє невеликий, але завершений вебзастосунок на `Laravel 13` для керування авторами, книгами та видачами книг.

Це не продукт для реального використання чи розгортання. Основна цінність репозиторію - показати якість реалізації, структуру коду, перевірки та зручний локальний запуск.

## Цілі

- Показати повний робочий CRUD для авторів і книг.
- Показати видачу та повернення книг з перевіркою доступної кількості примірників.
- Забезпечити пошук, фільтри, пагінацію та зрозумілий серверний рендеринг.
- Надати відтворюваний локальний запуск через `Docker` і `PostgreSQL`.
- Покрити основні сценарії тестами, браузерними перевірками та статичними quality gates.
- Тримати implementation flow близьким до кращих практик `Laravel`.

## Межі

Входить у scope:

- Сторінки `Books`, `Authors`, `Book loans`.
- Зв'язки: автор має багато книг, книга належить автору, книга має багато записів видачі.
- `Blade` UI, `SCSS`, npm-managed assets, custom JavaScript actions.
- `Pest`, `Laravel Dusk`, `Larastan/PHPStan`, `Laravel Pint`.
- `OpenSpec` artifacts для початкової постановки задачі.

Не входить у scope:

- Реєстрація, авторизація, ролі або права доступу.
- SPA, API-only frontend або окремий frontend framework.
- Production deployment, image publishing, secrets management або довготривала підтримка.
- Повноцінна бібліотечна доменна модель із історією повернень після видалення loan record.

## Обмеження

- Локальна база даних - `PostgreSQL`.
- Застосунок має запускатися швидко через `./run-local.sh`.
- Для кожного route використовується окремий invokable controller.
- Для кожного controller request використовується окремий `FormRequest`.
- Controllers і requests згруповані за manipulated entity.
- Статуси видачі книг централізовані в enum `App\Enums\LoanStatus`.

## Критерії Успіху

- `README.md` достатній для локального запуску та перевірки.
- CI badge показує стан workflow `Code Quality And Tests`.
- Основні команди проходять: `Pest`, `Dusk`, `Larastan/PHPStan`, `Pint`, asset build.
- `OpenSpec` change `build-library-management-app` валідний і позначений як виконаний.

Деталі продуктового контексту дивись у [productContext.md](./productContext.md), технічного контексту - у [techContext.md](./techContext.md).
