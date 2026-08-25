<?php

namespace App\Http\Controllers\Loans;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loans\DestroyLoanRequest;
use App\Models\BookLoan;
use Illuminate\Http\RedirectResponse;

class DestroyController extends Controller
{
    public function __invoke(DestroyLoanRequest $request, BookLoan $loan): RedirectResponse
    {
        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Book returned successfully.');
    }
}
