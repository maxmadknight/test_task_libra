<?php

namespace App\Http\Controllers\Loans;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loans\CreateLoanRequest;
use Illuminate\Http\RedirectResponse;

class CreateController extends Controller
{
    public function __invoke(CreateLoanRequest $request): RedirectResponse
    {
        return redirect()->route('loans.index');
    }
}
