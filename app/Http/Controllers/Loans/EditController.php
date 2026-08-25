<?php

namespace App\Http\Controllers\Loans;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loans\EditLoanRequest;
use App\Models\BookLoan;
use Illuminate\Http\RedirectResponse;

class EditController extends Controller
{
    public function __invoke(EditLoanRequest $request, BookLoan $loan): RedirectResponse
    {
        return redirect()->route('loans.index');
    }
}
