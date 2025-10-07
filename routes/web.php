<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BookLoanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index'])->name('home');

// Book routes
Route::resource('books', BookController::class);

// Book loan routes
Route::get('/loans', [BookLoanController::class, 'index'])->name('loans.index');
Route::post('/loans/borrow/{book}', [BookLoanController::class, 'borrow'])->name('loans.borrow');
Route::patch('/loans/{loan}/return', [BookLoanController::class, 'return'])->name('loans.return');
Route::get('/loans/create/{book}', [BookLoanController::class, 'create'])->name('loans.create');

// User routes (for member management)
Route::resource('users', UserController::class)->except(['show']);
Route::get('/users/{user}/loans', [UserController::class, 'loans'])->name('users.loans');