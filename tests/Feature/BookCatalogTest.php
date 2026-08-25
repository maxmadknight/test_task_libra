<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\BookLoan;

it('lists paginated books with author and availability data', function () {
    Book::factory()
        ->count(12)
        ->create();

    $response = $this->get(route('books.index'));

    $response
        ->assertOk()
        ->assertSee('Books')
        ->assertSee('Available');
});

it('creates a valid book', function () {
    $author = Author::factory()->create();

    $response = $this->post(route('books.store'), [
        'author_id' => $author->id,
        'title' => 'Domain-Driven Library',
        'publication_year' => 2025,
        'isbn' => '9783161484100',
        'copies_count' => 3,
    ]);

    $response->assertRedirect(route('books.index'));

    $this->assertDatabaseHas('books', [
        'title' => 'Domain-Driven Library',
        'author_id' => $author->id,
        'copies_count' => 3,
    ]);
});

it('validates required book fields and unique isbn', function () {
    Book::factory()->create(['isbn' => '9783161484100']);

    $response = $this->post(route('books.store'), [
        'isbn' => '9783161484100',
        'copies_count' => 0,
        'publication_year' => now()->addYear()->year,
    ]);

    $response->assertInvalid(['title', 'author_id', 'isbn', 'copies_count', 'publication_year']);
});

it('updates a book while keeping its isbn', function () {
    $book = Book::factory()->create(['isbn' => '9783161484100']);
    $author = Author::factory()->create();

    $response = $this->put(route('books.update', $book), [
        'author_id' => $author->id,
        'title' => 'Updated title',
        'publication_year' => 2024,
        'isbn' => '9783161484100',
        'copies_count' => 5,
    ]);

    $response->assertRedirect(route('books.index'));

    $this->assertDatabaseHas('books', [
        'id' => $book->id,
        'title' => 'Updated title',
        'isbn' => '9783161484100',
    ]);
});

it('prevents deleting a book with loans', function () {
    $loan = BookLoan::factory()->create();

    $response = $this->delete(route('books.destroy', $loan->book));

    $response->assertRedirect(route('books.index'));
    $this->assertDatabaseHas('books', ['id' => $loan->book_id]);
});
