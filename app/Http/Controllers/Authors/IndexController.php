<?php

namespace App\Http\Controllers\Authors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authors\IndexAuthorRequest;
use App\Models\Author;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    public function __invoke(IndexAuthorRequest $request): View
    {
        return view('authors.index', [
            'authors' => Author::query()
                ->with(['books' => fn ($query) => $query->orderBy('title')])
                ->withCount('books')
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->paginate(10),
        ]);
    }
}
