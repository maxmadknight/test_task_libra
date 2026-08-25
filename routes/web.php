<?php

use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\BookLoansController;
use App\Http\Controllers\BooksController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/books')->name('home');
Route::resource('authors', AuthorsController::class);
Route::resource('books', BooksController::class);
Route::resource('loans', BookLoansController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);
