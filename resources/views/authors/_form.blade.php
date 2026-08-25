@csrf

<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label" for="first_name">First name</label>
        <input class="form-control @error('first_name') is-invalid @enderror" id="first_name" name="first_name" value="{{ old('first_name', $author->first_name ?? '') }}" required>
        @error('first_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6">
        <label class="form-label" for="last_name">Last name</label>
        <input class="form-control @error('last_name') is-invalid @enderror" id="last_name" name="last_name" value="{{ old('last_name', $author->last_name ?? '') }}" required>
        @error('last_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="library-actions mt-4">
    <a class="btn btn-outline-secondary" href="{{ route('authors.index') }}">Cancel</a>
    <button class="btn btn-primary" type="submit">Save author</button>
</div>
