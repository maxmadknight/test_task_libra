<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBookRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $book = $this->route('book');

        return [
            'author_id' => ['required', 'integer', Rule::exists('authors', 'id')],
            'title' => ['required', 'string', 'max:255'],
            'publication_year' => ['required', 'integer', 'min:1000', 'max:'.now()->year],
            'isbn' => ['required', 'string', 'max:32', Rule::unique('books', 'isbn')->ignore($book)],
            'copies_count' => ['required', 'integer', 'min:1', 'max:1000'],
        ];
    }
}
