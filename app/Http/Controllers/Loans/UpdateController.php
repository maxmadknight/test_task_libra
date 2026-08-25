<?php

namespace App\Http\Controllers\Loans;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loans\UpdateLoanRequest;
use App\Models\BookLoan;
use Illuminate\Http\RedirectResponse;

class UpdateController extends Controller
{
    public function __invoke(UpdateLoanRequest $request, BookLoan $loan): RedirectResponse
    {
        return redirect()->route('loans.index');
    }
}
