<?php

namespace Database\Seeders;

use App\Enums\LoanStatus;
use App\Models\Author;
use App\Models\Book;
use App\Models\BookLoan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $authors = Author::factory()
            ->count(18)
            ->create();

        $books = $authors->flatMap(fn (Author $author) => Book::factory()
            ->count(2)
            ->create(['author_id' => $author->id]));

        $books->take(24)->each(function (Book $book, int $index): void {
            BookLoan::factory()->create([
                'book_id' => $book->id,
                'reader_name' => fake()->name(),
                'loaned_at' => now()->subDays($index + 2),
                'due_at' => $index % 3 === 0 ? now()->subDay() : now()->addDays($index + 3),
                'status' => $index % 3 === 0 ? LoanStatus::Overdue : LoanStatus::Active,
            ]);
        });

        $unavailableBook = $books->first();

        if (! $unavailableBook) {
            return;
        }

        $unavailableBook->update(['copies_count' => 1]);
    }
}
