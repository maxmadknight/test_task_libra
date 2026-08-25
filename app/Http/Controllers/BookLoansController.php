<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookLoanRequest;
use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class BookLoansController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->only(['reader_name', 'book_title', 'loaned_at', 'status']);

        return view('loans.index', [
            'filters' => $filters,
            'loans' => BookLoan::query()
                ->with('book.author')
                ->filtered($filters)
                ->latest('loaned_at')
                ->paginate(10)
                ->withQueryString(),
            'books' => Book::query()
                ->with('author', 'loans')
                ->orderBy('title')
                ->get(),
            'statuses' => [
                BookLoan::StatusActive => 'Active',
                BookLoan::StatusOverdue => 'Overdue',
            ],
        ]);
    }

    public function create(): RedirectResponse
    {
        return redirect()->route('loans.index');
    }

    public function store(StoreBookLoanRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $created = DB::transaction(function () use ($validated): bool {
            $book = Book::query()
                ->whereKey($validated['book_id'])
                ->lockForUpdate()
                ->firstOrFail();

            if ($book->availableCopies() < 1) {
                return false;
            }

            BookLoan::query()->create([
                'book_id' => $book->id,
                'reader_name' => $validated['reader_name'],
                'loaned_at' => now()->toDateString(),
                'due_at' => $validated['due_at'],
                'status' => Carbon::parse($validated['due_at'])->isPast() ? BookLoan::StatusOverdue : BookLoan::StatusActive,
            ]);

            return true;
        });

        if (! $created) {
            return redirect()
                ->route('loans.index')
                ->withInput()
                ->withErrors(['book_id' => 'No copies are available for this book.'])
                ->with('openLoanModal', true);
        }

        return redirect()->route('loans.index')->with('success', 'Book issued successfully.');
    }

    public function show(BookLoan $loan): RedirectResponse
    {
        return redirect()->route('loans.index');
    }

    public function edit(BookLoan $loan): RedirectResponse
    {
        return redirect()->route('loans.index');
    }

    public function update(Request $request, BookLoan $loan): RedirectResponse
    {
        return redirect()->route('loans.index');
    }

    public function destroy(BookLoan $loan): RedirectResponse
    {
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Book returned successfully.');
    }
}
