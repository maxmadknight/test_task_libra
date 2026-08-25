<?php

namespace App\Models;

use Database\Factories\BookFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['author_id', 'title', 'publication_year', 'isbn', 'copies_count'])]
class Book extends Model
{
    /** @use HasFactory<BookFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'publication_year' => 'integer',
            'copies_count' => 'integer',
        ];
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(BookLoan::class);
    }

    public function availableCopies(): int
    {
        $loanCount = $this->relationLoaded('loans')
            ? $this->loans->count()
            : $this->loans()->count();

        return max(0, $this->copies_count - $loanCount);
    }

    #[Scope]
    protected function available(Builder $query): void
    {
        $query->whereRaw('copies_count > (select count(*) from book_loans where book_loans.book_id = books.id)');
    }
}
