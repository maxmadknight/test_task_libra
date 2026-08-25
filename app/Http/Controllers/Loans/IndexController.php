<?php

namespace App\Http\Controllers\Loans;

use App\Enums\LoanStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Loans\IndexLoanRequest;
use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Contracts\View\View;

class IndexController extends Controller
{
    public function __invoke(IndexLoanRequest $request): View
    {
        $filters = $request->validated();

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
            'statuses' => LoanStatus::options(),
        ]);
    }
}
