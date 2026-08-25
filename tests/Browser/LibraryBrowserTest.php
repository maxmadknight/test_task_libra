<?php

use App\Models\Author;
use App\Models\Book;
use App\Models\BookLoan;
use Laravel\Dusk\Browser;

beforeEach(function () {
    $this->artisan('migrate:fresh');
});

it('opens the issue book modal and shows availability', function () {
    $book = Book::factory()->create([
        'title' => 'Browser Driven Design',
        'copies_count' => 2,
    ]);

    $this->browse(function (Browser $browser) use ($book) {
        $browser->visitRoute('loans.index')
            ->press('Issue book')
            ->waitFor('#issueBookModal')
            ->assertSee('Issue book')
            ->assertSee($book->title)
            ->assertSee('2 available');
    });
});

it('expands author books and confirms returns', function () {
    $author = Author::factory()->create([
        'first_name' => 'Mary',
        'last_name' => 'Shelley',
    ]);
    Book::factory()->create([
        'author_id' => $author->id,
        'title' => 'Frankenstein',
    ]);
    $loan = BookLoan::factory()->create([
        'reader_name' => 'Victor Reader',
    ]);

    $this->browse(function (Browser $browser) use ($author) {
        $browser->visitRoute('authors.index')
            ->assertSee('Mary Shelley')
            ->assertDontSee('Frankenstein')
            ->press("@author-books-toggle-{$author->id}")
            ->assertSee('Frankenstein')
            ->visitRoute('loans.index')
            ->assertSee('Victor Reader')
            ->press('Return')
            ->acceptDialog()
            ->waitUntilMissingText('Victor Reader');
    });

    expect(BookLoan::query()->whereKey($loan->id)->exists())->toBeFalse();
});

it('renders responsive navigation and book list', function () {
    Book::factory()->create(['title' => 'Small Screen Catalog']);

    $this->browse(function (Browser $browser) {
        $browser->resize(390, 844)
            ->visitRoute('books.index')
            ->assertSee('Library Manager')
            ->assertSee('Small Screen Catalog');
    });
});
