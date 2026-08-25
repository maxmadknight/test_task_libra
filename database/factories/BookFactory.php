<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Book> */
class BookFactory extends Factory
{
    public function definition(): array
    {
        return [
            'author_id' => Author::factory(),
            'title' => fake()->unique()->sentence(3),
            'publication_year' => fake()->numberBetween(1950, (int) now()->year),
            'isbn' => fake()->unique()->isbn13(),
            'copies_count' => fake()->numberBetween(1, 6),
        ];
    }
}
