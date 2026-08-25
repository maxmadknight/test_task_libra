<?php

namespace App\Models;

use App\Enums\LoanStatus;
use Database\Factories\BookLoanFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['book_id', 'reader_name', 'loaned_at', 'due_at', 'status'])]
class BookLoan extends Model
{
    /** @use HasFactory<BookLoanFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'loaned_at' => 'date',
            'due_at' => 'date',
            'status' => LoanStatus::class,
        ];
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    #[Scope]
    protected function filtered(Builder $query, array $filters): void
    {
        $query
            ->when($filters['reader_name'] ?? null, fn (Builder $query, string $readerName) => $query->where('reader_name', 'like', "%{$readerName}%"))
            ->when($filters['book_title'] ?? null, fn (Builder $query, string $bookTitle) => $query->whereHas('book', fn (Builder $query) => $query->where('title', 'like', "%{$bookTitle}%")))
            ->when($filters['loaned_at'] ?? null, fn (Builder $query, string $loanedAt) => $query->whereDate('loaned_at', $loanedAt))
            ->when($filters['status'] ?? null, fn (Builder $query, string $status) => $query->where('status', $status));
    }
}
