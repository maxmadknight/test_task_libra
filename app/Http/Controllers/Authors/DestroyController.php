<?php

namespace App\Http\Controllers\Authors;

use App\Http\Controllers\Controller;
use App\Http\Requests\Authors\DestroyAuthorRequest;
use App\Models\Author;
use Illuminate\Http\RedirectResponse;

class DestroyController extends Controller
{
    public function __invoke(DestroyAuthorRequest $request, Author $author): RedirectResponse
    {
        if ($author->books()->exists()) {
            return redirect()->route('authors.index')->with('error', 'Delete or reassign this author\'s books first.');
        }

        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
    }
}
