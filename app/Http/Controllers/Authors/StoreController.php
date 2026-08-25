<?php

namespace App\Http\Controllers\Authors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authors\StoreAuthorRequest;
use App\Models\Author;
use Illuminate\Http\RedirectResponse;

class StoreController extends Controller
{
    public function __invoke(StoreAuthorRequest $request): RedirectResponse
    {
        Author::query()->create($request->validated());

        return redirect()->route('authors.index')->with('success', 'Author created successfully.');
    }
}
