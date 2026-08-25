<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\Books\IndexBookRequest;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    public function __invoke(IndexBookRequest $request): View
    {
        $filters = $request->validated();

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
            ->when($filters['author_id'] ?? null, fn ($query, int $authorId) => $query->where('author_id', $authorId))
            ->when($filters['published_from'] ?? null, fn ($query, int $year) => $query->where('publication_year', '>=', $year))
            ->when($filters['published_to'] ?? null, fn ($query, int $year) => $query->where('publication_year', '<=', $year))
            ->orderBy('title');

        if (($filters['availability'] ?? '') === 'available') {
            $books->whereRaw('copies_count > (select count(*) from book_loans where book_loans.book_id = books.id)');
        }

        if (($filters['availability'] ?? '') === 'unavailable') {
            $books->whereRaw('copies_count <= (select count(*) from book_loans where book_loans.book_id = books.id)');
        }

        return view('books.index', [
            'authors' => Author::query()
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get(),
            'books' => $books->paginate(10)->withQueryString(),
            'filters' => $filters,
        ]);
    }
}
