<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreBookLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'book_id' => ['required', 'integer', 'exists:books,id'],
            'reader_name' => ['required', 'string', 'max:255'],
            'due_at' => ['required', 'date', 'after_or_equal:today'],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $bookId = $this->integer('book_id');

                if (! $bookId) {
                    return;
                }

                $book = Book::query()->with('loans')->find($bookId);

                if (! $book || $book->availableCopies() > 0) {
                    return;
                }

                $validator->errors()->add('book_id', 'No copies are available for this book.');
            },
        ];
    }
}
