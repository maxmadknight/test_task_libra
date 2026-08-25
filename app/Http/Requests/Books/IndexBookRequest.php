<?php

namespace App\Http\Requests\Books;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'author_id' => ['nullable', 'integer', Rule::exists('authors', 'id')],
            'availability' => ['nullable', 'string', Rule::in(['available', 'unavailable'])],
            'published_from' => ['nullable', 'integer', 'min:1000', 'max:'.now()->year],
            'published_to' => ['nullable', 'integer', 'min:1000', 'max:'.now()->year],
            'search' => ['nullable', 'string', 'max:255'],
        ];
    }
}
