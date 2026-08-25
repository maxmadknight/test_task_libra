<?php

namespace App\Http\Controllers\Authors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authors\CreateAuthorRequest;
use Illuminate\Contracts\View\View;

class CreateController extends Controller
{
    public function __invoke(CreateAuthorRequest $request): View
    {
        return view('authors.create');
    }
}
