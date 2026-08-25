<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\Books\StoreBookRequest;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;

class StoreController extends Controller
{
    public function __invoke(StoreBookRequest $request): RedirectResponse
    {
        Book::query()->create($request->validated());

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }
}
