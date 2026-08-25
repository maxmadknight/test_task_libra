<?php

use App\Models\Author;
use App\Models\Book;

it('lists paginated authors with expandable book data available', function () {
    $author = Author::factory()->create([
        'first_name' => 'Octavia',
        'last_name' => 'Butler',
    ]);
    Book::factory()->create([
        'author_id' => $author->id,
        'title' => 'Kindred',
    ]);
    Author::factory()->count(11)->create();

    $response = $this->get(route('authors.index'));

    $response
        ->assertOk()
        ->assertSee('Octavia Butler')
        ->assertSee('Kindred')
        ->assertSee('Show books');
});

it('creates and updates authors', function () {
    $this->post(route('authors.store'), [
        'first_name' => 'Ursula',
        'last_name' => 'Le Guin',
    ])->assertRedirect(route('authors.index'));

    $author = Author::query()->where('last_name', 'Le Guin')->firstOrFail();

    $this->put(route('authors.update', $author), [
        'first_name' => 'Ursula K.',
        'last_name' => 'Le Guin',
    ])->assertRedirect(route('authors.index'));

    $this->assertDatabaseHas('authors', [
        'id' => $author->id,
        'first_name' => 'Ursula K.',
    ]);
});

it('validates author fields', function () {
    $this->post(route('authors.store'), [])->assertInvalid(['first_name', 'last_name']);
});

it('prevents deleting an author with books', function () {
    $book = Book::factory()->create();

    $this->delete(route('authors.destroy', $book->author))->assertRedirect(route('authors.index'));

    $this->assertDatabaseHas('authors', ['id' => $book->author_id]);
});
