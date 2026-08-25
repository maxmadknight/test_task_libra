@extends('layouts.app')

@section('content')
    <div class="library-page__header">
        <h1 class="library-page__title">Edit book</h1>
    </div>

    <form class="library-panel library-panel__body" method="POST" action="{{ route('books.update', $book) }}">
        @method('PUT')
        @include('books._form')
    </form>
@endsection
