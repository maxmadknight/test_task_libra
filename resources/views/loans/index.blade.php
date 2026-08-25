@extends('layouts.app')

@section('content')
    <div class="library-page__header">
        <div>
            <h1 class="library-page__title">Book loans</h1>
            <p class="text-secondary mb-0">Issue books, filter current loans, and return books by removing loan records.</p>
        </div>
        <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#issueBookModal">Issue book</button>
    </div>

    <form class="library-panel library-panel__body mb-3" method="GET" action="{{ route('loans.index') }}">
        <div class="library-filter">
            <input class="form-control" name="reader_name" placeholder="Reader name" value="{{ $filters['reader_name'] ?? '' }}">
            <input class="form-control" name="book_title" placeholder="Book title" value="{{ $filters['book_title'] ?? '' }}">
            <input class="form-control" type="date" name="loaned_at" value="{{ $filters['loaned_at'] ?? '' }}">
            <select class="form-select" name="status">
                <option value="">Any status</option>
                @foreach($statuses as $value => $label)
                    <option value="{{ $value }}" @selected(($filters['status'] ?? '') === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="btn btn-outline-primary" type="submit">Filter</button>
        </div>
    </form>

    <div class="library-panel">
        <div class="table-responsive">
            <table class="table library-table align-middle">
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Reader</th>
                        <th>Loaned</th>
                        <th>Due</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($loans as $loan)
                        <tr>
                            <td>{{ $loan->book->title }}</td>
                            <td>{{ $loan->reader_name }}</td>
                            <td>{{ $loan->loaned_at->toDateString() }}</td>
                            <td>{{ $loan->due_at->toDateString() }}</td>
                            <td><span class="badge text-bg-{{ $loan->status === 'overdue' ? 'danger' : 'success' }}">{{ ucfirst($loan->status) }}</span></td>
                            <td>
                                <div class="library-actions">
                                    <form method="POST" action="{{ route('loans.destroy', $loan) }}" data-confirm-return>
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-outline-primary" type="submit">Return</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="library-empty" colspan="6">No loans found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $loans->links() }}</div>

    <div class="modal fade" id="issueBookModal" tabindex="-1" aria-labelledby="issueBookModalLabel" aria-hidden="true" data-open-on-load="{{ $errors->any() || session('openLoanModal') ? 'true' : 'false' }}">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="{{ route('loans.store') }}">
                @csrf
                <div class="modal-header">
                    <h2 class="modal-title fs-5" id="issueBookModalLabel">Issue book</h2>
                    <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label" for="book_id">Book</label>
                        <select class="form-select @error('book_id') is-invalid @enderror" id="book_id" name="book_id" required>
                            <option value="">Choose book</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" @disabled($book->availableCopies() < 1) @selected((int) old('book_id') === $book->id)>
                                    {{ $book->title }} by {{ $book->author->full_name }} - {{ $book->availableCopies() }} available
                                </option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="reader_name">Reader name</label>
                        <input class="form-control @error('reader_name') is-invalid @enderror" id="reader_name" name="reader_name" value="{{ old('reader_name') }}" required>
                        @error('reader_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="form-label" for="due_at">Due date</label>
                        <input class="form-control @error('due_at') is-invalid @enderror" id="due_at" type="date" name="due_at" value="{{ old('due_at') }}" required>
                        @error('due_at')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit">Issue book</button>
                </div>
            </form>
        </div>
    </div>
@endsection
