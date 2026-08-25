@extends('layouts.app')

@section('content')
    <div class="library-page__header">
        <div>
            <h1 class="library-page__title">Books</h1>
            <p class="text-secondary mb-0">Manage titles, authors, ISBNs, and available copy counts.</p>
        </div>
        <a class="btn btn-primary" href="{{ route('books.create') }}">Add book</a>
    </div>

    <form class="library-panel library-panel__body mb-3" method="GET" action="{{ route('books.index') }}">
        <div class="library-book-filter">
            <div class="library-filter__search">
                <label class="form-label" for="search">Search</label>
                <input class="form-control" id="search" name="search" placeholder="Title, ISBN, or author" value="{{ $filters['search'] ?? '' }}">
            </div>

            <div>
                <label class="form-label" for="author_id">Author</label>
                <select class="form-select" id="author_id" name="author_id" data-searchable-select data-placeholder="Any author">
                    <option value="">Any author</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" @selected((string) ($filters['author_id'] ?? '') === (string) $author->id)>{{ $author->full_name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label" for="availability">Availability</label>
                <select class="form-select" id="availability" name="availability">
                    <option value="">Any availability</option>
                    <option value="available" @selected(($filters['availability'] ?? '') === 'available')>Available</option>
                    <option value="unavailable" @selected(($filters['availability'] ?? '') === 'unavailable')>Unavailable</option>
                </select>
            </div>

            <div>
                <label class="form-label" for="published_from">From year</label>
                <input class="form-control" id="published_from" type="number" name="published_from" min="1000" max="{{ now()->year }}" value="{{ $filters['published_from'] ?? '' }}">
            </div>

            <div>
                <label class="form-label" for="published_to">To year</label>
                <input class="form-control" id="published_to" type="number" name="published_to" min="1000" max="{{ now()->year }}" value="{{ $filters['published_to'] ?? '' }}">
            </div>

            <div class="library-filter__actions">
                <button class="btn btn-outline-primary" type="submit">Filter</button>
                <a class="btn btn-outline-secondary" href="{{ route('books.index') }}">Reset</a>
            </div>
        </div>
    </form>

    <div class="library-panel">
        <div class="table-responsive">
            <table class="table library-table align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Year</th>
                        <th>ISBN</th>
                        <th>Copies</th>
                        <th>Available</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author->full_name }}</td>
                            <td>{{ $book->publication_year }}</td>
                            <td>{{ $book->isbn }}</td>
                            <td>{{ $book->copies_count }}</td>
                            <td>{{ max(0, $book->copies_count - $book->loans_count) }}</td>
                            <td>
                                <div class="library-actions">
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('books.edit', $book) }}">Edit</a>
                                    <form method="POST" action="{{ route('books.destroy', $book) }}" data-confirm-delete="Delete this book?">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="library-empty" colspan="7">No books found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $books->links() }}</div>
@endsection
