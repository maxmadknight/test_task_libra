<?php

namespace App\Http\Controllers\Authors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authors\EditAuthorRequest;
use App\Models\Author;
use Illuminate\Contracts\View\View;

class EditController extends Controller
{
    public function __invoke(EditAuthorRequest $request, Author $author): View
    {
        $author->load([
            'books' => fn ($query) => $query
                ->withCount('loans')
                ->orderBy('title'),
        ]);

        return view('authors.edit', [
            'author' => $author,
        ]);
    }
}
