<?php

namespace App\Http\Controllers\Loans;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loans\ShowLoanRequest;
use App\Models\BookLoan;
use Illuminate\Http\RedirectResponse;

class ShowController extends Controller
{
    public function __invoke(ShowLoanRequest $request, BookLoan $loan): RedirectResponse
    {
        return redirect()->route('loans.index');
    }
}
