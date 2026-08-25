<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BooksController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only([
            'author_id',
            'availability',
            'published_from',
            'published_to',
            'search',
        ]);

        $books = Book::query()
            ->with('author')
            ->withCount('loans')
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('isbn', 'like', "%{$search}%")
                        ->orWhereHas('author', function ($query) use ($search) {
                            $query
                                ->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($filters['author_id'] ?? null, fn ($query, string $authorId) => $query->where('author_id', $authorId))
            ->when($filters['published_from'] ?? null, fn ($query, string $year) => $query->where('publication_year', '>=', $year))
            ->when($filters['published_to'] ?? null, fn ($query, string $year) => $query->where('publication_year', '<=', $year))
            ->orderBy('title');

        if (($filters['availability'] ?? '') === 'available') {
            $books->whereRaw('copies_count > (select count(*) from book_loans where book_loans.book_id = books.id)');
        }

        if (($filters['availability'] ?? '') === 'unavailable') {
            $books->whereRaw('copies_count <= (select count(*) from book_loans where book_loans.book_id = books.id)');
        }

        return view('books.index', [
            'authors' => $this->authorsForSelect(),
            'books' => $books->paginate(10)->withQueryString(),
            'filters' => $filters,
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
