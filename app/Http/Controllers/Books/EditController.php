<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\Books\EditBookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Contracts\View\View;

class EditController extends Controller
{
    public function __invoke(EditBookRequest $request, Book $book): View
    {
        return view('books.edit', [
            'book' => $book,
            'authors' => Author::query()
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get(),
        ]);
    }
}
