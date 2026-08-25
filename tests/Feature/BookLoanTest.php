<?php

use App\Enums\LoanStatus;
use App\Models\Book;
use App\Models\BookLoan;

it('lists loans with filters and preserves pagination query parameters', function () {
    BookLoan::factory()->count(12)->create([
        'reader_name' => 'Ada Reader',
        'loaned_at' => '2026-08-20',
        'status' => LoanStatus::Active,
    ]);
    BookLoan::factory()->count(12)->create();

    $response = $this->get(route('loans.index', [
        'reader_name' => 'Ada',
        'loaned_at' => '2026-08-20',
        'status' => LoanStatus::Active->value,
    ]));

    $response
        ->assertOk()
        ->assertSee('Ada Reader')
        ->assertSee('reader_name=Ada', false);
});

it('creates a loan when copies are available', function () {
    $book = Book::factory()->create(['copies_count' => 2]);

    $response = $this->post(route('loans.store'), [
        'book_id' => $book->id,
        'reader_name' => 'Grace Hopper',
        'due_at' => now()->addWeek()->toDateString(),
    ]);

    $response->assertRedirect(route('loans.index'));

    $this->assertDatabaseHas('book_loans', [
        'book_id' => $book->id,
        'reader_name' => 'Grace Hopper',
        'status' => LoanStatus::Active->value,
    ]);
});

it('rejects unavailable books', function () {
    $book = Book::factory()->create(['copies_count' => 1]);
    BookLoan::factory()->create(['book_id' => $book->id]);

    $response = $this->post(route('loans.store'), [
        'book_id' => $book->id,
        'reader_name' => 'Alan Turing',
        'due_at' => now()->addWeek()->toDateString(),
    ]);

    $response->assertInvalid(['book_id']);
    expect(BookLoan::query()->where('book_id', $book->id)->count())->toBe(1);
});

it('validates loan fields', function () {
    $this->post(route('loans.store'), [])->assertInvalid(['book_id', 'reader_name', 'due_at']);
});

it('returns a book by deleting the loan', function () {
    $loan = BookLoan::factory()->create();

    $this->delete(route('loans.destroy', $loan))->assertRedirect(route('loans.index'));

    $this->assertDatabaseMissing('book_loans', ['id' => $loan->id]);
});
