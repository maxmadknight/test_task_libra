<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;

class BooksController extends Controller
{
    public function index(): View
    {
        return view('books.index', [
            'books' => Book::query()
                ->with('author')
                ->withCount('loans')
                ->orderBy('title')
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('books.create', [
            'authors' => $this->authorsForSelect(),
        ]);
    }

    public function store(StoreBookRequest $request): RedirectResponse
    {
        Book::query()->create($request->validated());

        return redirect()->route('books.index')->with('success', 'Book created successfully.');
    }

    public function show(Book $book): RedirectResponse
    {
        return redirect()->route('books.edit', $book);
    }

    public function edit(Book $book): View
    {
        return view('books.edit', [
            'book' => $book,
            'authors' => $this->authorsForSelect(),
        ]);
    }

    public function update(UpdateBookRequest $request, Book $book): RedirectResponse
    {
        $book->update($request->validated());

        return redirect()->route('books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book): RedirectResponse
    {
        if ($book->loans()->exists()) {
            return redirect()->route('books.index')->with('error', 'Return all copies before deleting this book.');
        }

        $book->delete();

        return redirect()->route('books.index')->with('success', 'Book deleted successfully.');
    }

    private function authorsForSelect(): Collection
    {
        return Author::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();
    }
}
