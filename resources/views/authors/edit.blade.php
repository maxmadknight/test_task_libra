@extends('layouts.app')

@section('content')
    <div class="library-page__header">
        <h1 class="library-page__title">Edit author</h1>
    </div>

    <form class="library-panel library-panel__body" method="POST" action="{{ route('authors.update', $author) }}">
        @method('PUT')
        @include('authors._form')
    </form>

    <section class="library-panel mt-3">
        <div class="library-panel__body">
            <h2 class="library-section-title">Related books</h2>
        </div>

        <div class="table-responsive">
            <table class="table library-table align-middle">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Year</th>
                        <th>ISBN</th>
                        <th>Copies</th>
                        <th>Loan status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($author->books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->publication_year }}</td>
                            <td>{{ $book->isbn }}</td>
                            <td>{{ $book->copies_count }}</td>
                            <td>
                                @if($book->loans_count > 0)
                                    <span class="badge text-bg-warning">Loaned</span>
                                    <span class="text-secondary ms-1">{{ $book->loans_count }} active</span>
                                @else
                                    <span class="badge text-bg-success">Not loaned</span>
                                @endif
                            </td>
                            <td>
                                <div class="library-actions">
                                    <a class="btn btn-sm btn-outline-primary" href="{{ route('books.edit', $book) }}">Edit book</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="library-empty" colspan="6">No books assigned to this author.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
