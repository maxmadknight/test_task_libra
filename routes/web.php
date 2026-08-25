<?php

use App\Http\Controllers\Authors\CreateController as CreateAuthorController;
use App\Http\Controllers\Authors\DestroyController as DestroyAuthorController;
use App\Http\Controllers\Authors\EditController as EditAuthorController;
use App\Http\Controllers\Authors\IndexController as IndexAuthorController;
use App\Http\Controllers\Authors\ShowController as ShowAuthorController;
use App\Http\Controllers\Authors\StoreController as StoreAuthorController;
use App\Http\Controllers\Authors\UpdateController as UpdateAuthorController;
use App\Http\Controllers\Books\CreateController as CreateBookController;
use App\Http\Controllers\Books\DestroyController as DestroyBookController;
use App\Http\Controllers\Books\EditController as EditBookController;
use App\Http\Controllers\Books\IndexController as IndexBookController;
use App\Http\Controllers\Books\ShowController as ShowBookController;
use App\Http\Controllers\Books\StoreController as StoreBookController;
use App\Http\Controllers\Books\UpdateController as UpdateBookController;
use App\Http\Controllers\Loans\CreateController as CreateLoanController;
use App\Http\Controllers\Loans\DestroyController as DestroyLoanController;
use App\Http\Controllers\Loans\EditController as EditLoanController;
use App\Http\Controllers\Loans\IndexController as IndexLoanController;
use App\Http\Controllers\Loans\ShowController as ShowLoanController;
use App\Http\Controllers\Loans\StoreController as StoreLoanController;
use App\Http\Controllers\Loans\UpdateController as UpdateLoanController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/books')->name('home');

Route::get('authors', IndexAuthorController::class)->name('authors.index');
Route::get('authors/create', CreateAuthorController::class)->name('authors.create');
Route::post('authors', StoreAuthorController::class)->name('authors.store');
Route::get('authors/{author}', ShowAuthorController::class)->name('authors.show');
Route::get('authors/{author}/edit', EditAuthorController::class)->name('authors.edit');
Route::match(['put', 'patch'], 'authors/{author}', UpdateAuthorController::class)->name('authors.update');
Route::delete('authors/{author}', DestroyAuthorController::class)->name('authors.destroy');

Route::get('books', IndexBookController::class)->name('books.index');
Route::get('books/create', CreateBookController::class)->name('books.create');
Route::post('books', StoreBookController::class)->name('books.store');
Route::get('books/{book}', ShowBookController::class)->name('books.show');
Route::get('books/{book}/edit', EditBookController::class)->name('books.edit');
Route::match(['put', 'patch'], 'books/{book}', UpdateBookController::class)->name('books.update');
Route::delete('books/{book}', DestroyBookController::class)->name('books.destroy');

Route::get('loans', IndexLoanController::class)->name('loans.index');
Route::get('loans/create', CreateLoanController::class)->name('loans.create');
Route::post('loans', StoreLoanController::class)->name('loans.store');
Route::get('loans/{loan}', ShowLoanController::class)->name('loans.show');
Route::get('loans/{loan}/edit', EditLoanController::class)->name('loans.edit');
Route::match(['put', 'patch'], 'loans/{loan}', UpdateLoanController::class)->name('loans.update');
Route::delete('loans/{loan}', DestroyLoanController::class)->name('loans.destroy');
