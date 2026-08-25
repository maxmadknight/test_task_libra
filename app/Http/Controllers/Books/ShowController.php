<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\Books\ShowBookRequest;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;

class ShowController extends Controller
{
    public function __invoke(ShowBookRequest $request, Book $book): RedirectResponse
    {
        return redirect()->route('books.edit', $book);
    }
}
