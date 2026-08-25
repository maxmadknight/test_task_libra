# Активний Контекст

## Поточний Фокус

Проєкт наразі доведений до завершеного стану для тестового завдання. Поточна задача - підтримувати repo context через **Memory Bank**, щоб наступні зміни не розходилися зі scope.

## Нещодавні Зміни

- Додано CI badge у `README.md` для workflow `CI/CD`.
- Прибрано `build-and-publish-image`, бо застосунок не буде використовуватися або деплоїтися.
- Controllers переписані на one route - one invokable controller.
- Requests згруповані за entity і підключені до кожного controller action.
- Додано enum `App\Enums\LoanStatus` для статусів loan.
- На author edit page показуються related books і loan status.
- На books page author name веде до author page.
- Додано пошук і фільтри для books, searchable dropdowns через `Tom Select`.

## Поточні Джерела Правди

- Scope і setup: `README.md`.
- Change-scoped вимоги: `openspec/changes/build-library-management-app/`.
- Routes: `routes/web.php`.
- Entity controllers: `app/Http/Controllers/{Authors,Books,Loans}`.
- Entity requests: `app/Http/Requests/{Authors,Books,Loans}`.
- Loan statuses: `app/Enums/LoanStatus.php`.
- CI: `.github/workflows/ci.yml`.
- Local development shortcuts: `Makefile`.

## Наступні Кроки

- Після кожної суттєвої зміни оновлювати [progress.md](./progress.md) і цей файл.
- Якщо змінюється архітектурне рішення, додати або оновити запис у [decisinLog.md](./decisinLog.md).
- Якщо `OpenSpec` буде архівовано, відобразити це в [progress.md](./progress.md).
- Перед commit запускати `make precommit`, якщо зміни зачіпають код, тести, assets або `OpenSpec`.

## Відкриті Питання

- Чи треба архівувати `openspec/changes/build-library-management-app`, якщо команда вважає зміну завершеною.
- Чи треба зберігати історію повернень книг замість видалення loan record; поточний scope цього не вимагає.

## Активні Ризики

- `Pest` і `Dusk` не запускати паралельно в поточному локальному setup, бо вони скидають одну й ту саму test database.
- `OpenSpec` design частково старіший за код: там згадується resource controllers і enum-like string, але поточна реалізація вже використовує invokable controllers і `LoanStatus`.
