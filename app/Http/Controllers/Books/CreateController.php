<?php

namespace App\Http\Controllers\Books;

use App\Http\Controllers\Controller;
use App\Http\Requests\Books\CreateBookRequest;
use App\Models\Author;
use Illuminate\Contracts\View\View;

class CreateController extends Controller
{
    public function __invoke(CreateBookRequest $request): View
    {
        return view('books.create', [
            'authors' => Author::query()
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->get(),
        ]);
    }
}
