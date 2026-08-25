@extends('layouts.app')

@section('content')
    <div class="library-page__header">
        <h1 class="library-page__title">Add author</h1>
    </div>

    <form class="library-panel library-panel__body" method="POST" action="{{ route('authors.store') }}">
        @include('authors._form')
    </form>
@endsection
