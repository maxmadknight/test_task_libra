<?php

namespace App\Http\Controllers\Loans;

use App\Enums\LoanStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Loans\StoreLoanRequest;
use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function __invoke(StoreLoanRequest $request): RedirectResponse
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
                'status' => Carbon::parse($validated['due_at'])->isPast() ? LoanStatus::Overdue : LoanStatus::Active,
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
}
