<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthorRequest;
use App\Http\Requests\UpdateAuthorRequest;
use App\Models\Author;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class AuthorsController extends Controller
{
    public function index(): View
    {
        return view('authors.index', [
            'authors' => Author::query()
                ->with(['books' => fn ($query) => $query->orderBy('title')])
                ->withCount('books')
                ->orderBy('last_name')
                ->orderBy('first_name')
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('authors.create');
    }

    public function store(StoreAuthorRequest $request): RedirectResponse
    {
        Author::query()->create($request->validated());

        return redirect()->route('authors.index')->with('success', 'Author created successfully.');
    }

    public function show(Author $author): RedirectResponse
    {
        return redirect()->route('authors.edit', $author);
    }

    public function edit(Author $author): View
    {
        $author->load([
            'books' => fn ($query) => $query
                ->withCount('loans')
                ->orderBy('title'),
        ]);

        return view('authors.edit', [
            'author' => $author,
        ]);
    }

    public function update(UpdateAuthorRequest $request, Author $author): RedirectResponse
    {
        $author->update($request->validated());

        return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
    }

    public function destroy(Author $author): RedirectResponse
    {
        if ($author->books()->exists()) {
            return redirect()->route('authors.index')->with('error', 'Delete or reassign this author\'s books first.');
        }

        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
    }
}
