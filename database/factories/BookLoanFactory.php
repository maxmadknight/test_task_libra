<?php

namespace Database\Factories;

use App\Enums\LoanStatus;
use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<BookLoan> */
class BookLoanFactory extends Factory
{
    public function definition(): array
    {
        $loanedAt = fake()->dateTimeBetween('-45 days', '-1 day');
        $dueAt = fake()->dateTimeBetween($loanedAt, '+21 days');

        return [
            'book_id' => Book::factory(),
            'reader_name' => fake()->name(),
            'loaned_at' => $loanedAt,
            'due_at' => $dueAt,
            'status' => $dueAt < now() ? LoanStatus::Overdue : LoanStatus::Active,
        ];
    }
}
