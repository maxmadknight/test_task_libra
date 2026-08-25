@extends('layouts.app')

@section('content')
    <div class="library-page__header">
        <div>
            <h1 class="library-page__title">Authors</h1>
            <p class="text-secondary mb-0">Browse authors and expand their book lists inline.</p>
        </div>
        <a class="btn btn-primary" href="{{ route('authors.create') }}">Add author</a>
    </div>

    <div class="library-panel">
        <div class="table-responsive">
            <table class="table library-table align-middle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Books</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($authors as $author)
                        <tr>
                            <td>
                                <strong>{{ $author->full_name }}</strong>
                                @if($author->books->isNotEmpty())
                                    <div>
                                        <button class="btn btn-sm btn-link px-0" type="button" data-author-books-toggle="#author-books-{{ $author->id }}" aria-expanded="false" dusk="author-books-toggle-{{ $author->id }}">
                                            Show books
                                        </button>
                                        <div class="library-book-list" id="author-books-{{ $author->id }}" dusk="author-books-list-{{ $author->id }}" hidden>
                                            <ul class="mb-0">
                                                @foreach($author->books as $book)
                                                    <li>{{ $book->title }} ({{ $book->publication_year }})</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif
                            </td>
                            <td>{{ $author->books_count }}</td>
                            <td>
                                <div class="library-actions">
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('authors.edit', $author) }}">Edit</a>
                                    <form method="POST" action="{{ route('authors.destroy', $author) }}" data-confirm-delete="Delete this author?">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="library-empty" colspan="3">No authors found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $authors->links() }}</div>
@endsection
