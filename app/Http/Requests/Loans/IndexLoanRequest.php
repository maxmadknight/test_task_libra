<?php

namespace App\Http\Requests\Loans;

use App\Enums\LoanStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexLoanRequest extends FormRequest
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
            'book_title' => ['nullable', 'string', 'max:255'],
            'loaned_at' => ['nullable', 'date'],
            'reader_name' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', Rule::enum(LoanStatus::class)],
        ];
    }
}
