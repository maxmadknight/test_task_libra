@extends('layouts.app')

@section('content')
    <div class="library-page__header">
        <div>
            <h1 class="library-page__title">Books</h1>
            <p class="text-secondary mb-0">Manage titles, authors, ISBNs, and available copy counts.</p>
        </div>
        <a class="btn btn-primary" href="{{ route('books.create') }}">Add book</a>
    </div>

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
