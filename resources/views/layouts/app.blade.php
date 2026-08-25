<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
</head>
<body>
    <div class="library-shell">
        <nav class="navbar navbar-expand-lg library-navbar">
            <div class="container">
                <a class="navbar-brand library-brand" href="{{ route('books.index') }}">Library Manager</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation" aria-controls="mainNavigation" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mainNavigation">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link @if(request()->routeIs('books.*')) active @endif" href="{{ route('books.index') }}">Books</a></li>
                        <li class="nav-item"><a class="nav-link @if(request()->routeIs('authors.*')) active @endif" href="{{ route('authors.index') }}">Authors</a></li>
                        <li class="nav-item"><a class="nav-link @if(request()->routeIs('loans.*')) active @endif" href="{{ route('loans.index') }}">Loans</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="library-page">
            <div class="container">
                @if(session('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
