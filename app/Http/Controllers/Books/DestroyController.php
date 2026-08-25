<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\Books\DestroyBookRequest;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;

class DestroyController extends Controller
{
    public function __invoke(DestroyBookRequest $request, Book $book): RedirectResponse
    {
        if ($book->loans()->exists()) {
            return redirect()->route('books.index')->with('error', 'Return all copies before deleting this book.');
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }
}
