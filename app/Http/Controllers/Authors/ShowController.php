<?php

namespace App\Http\Controllers\Authors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authors\ShowAuthorRequest;
use App\Models\Author;
use Illuminate\Http\RedirectResponse;

class ShowController extends Controller
{
    public function __invoke(ShowAuthorRequest $request, Author $author): RedirectResponse
    {
        return redirect()->route('authors.edit', $author);
    }
}
