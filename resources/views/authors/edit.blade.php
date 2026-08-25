@extends('layouts.app')

@section('content')
    <div class="library-page__header">
        <h1 class="library-page__title">Edit author</h1>
    </div>

    <form class="library-panel library-panel__body" method="POST" action="{{ route('authors.update', $author) }}">
        @method('PUT')
        @include('authors._form')
    </form>
@endsection
