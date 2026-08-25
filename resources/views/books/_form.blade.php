@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="title">Title</label>
        <input class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $book->title ?? '') }}" required>
        @error('title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="author_id">Author</label>
        <select class="form-select @error('author_id') is-invalid @enderror" id="author_id" name="author_id" required>
            <option value="">Choose author</option>
            @foreach($authors as $author)
                <option value="{{ $author->id }}" @selected((int) old('author_id', $book->author_id ?? 0) === $author->id)>{{ $author->full_name }}</option>
            @endforeach
        </select>
        @error('author_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label" for="publication_year">Publication year</label>
        <input class="form-control @error('publication_year') is-invalid @enderror" id="publication_year" type="number" name="publication_year" min="1000" max="{{ now()->year }}" value="{{ old('publication_year', $book->publication_year ?? '') }}" required>
        @error('publication_year')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label" for="isbn">ISBN</label>
        <input class="form-control @error('isbn') is-invalid @enderror" id="isbn" name="isbn" value="{{ old('isbn', $book->isbn ?? '') }}" required>
        @error('isbn')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-4">
        <label class="form-label" for="copies_count">Copies</label>
        <input class="form-control @error('copies_count') is-invalid @enderror" id="copies_count" type="number" name="copies_count" min="1" value="{{ old('copies_count', $book->copies_count ?? 1) }}" required>
        @error('copies_count')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="library-actions mt-4">
    <a class="btn btn-outline-secondary" href="{{ route('books.index') }}">Cancel</a>
    <button class="btn btn-primary" type="submit">Save book</button>
</div>
