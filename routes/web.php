<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DebitController;
use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Auth;

Route::middleware(['auth', CheckRole::class . ':admin,bibliotecario'])->group(function () {
    Route::post('/books/{book}/borrow', [BorrowingController::class, 'store'])->name('books.borrow');
    Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');

    // Rotas para controle de débitos (bibliotecário)
    Route::get('/debitos', [CheckRole::class, 'index'])->name('debitos.index');
    Route::post('/debitos/{user}/clear', [CheckRole::class, 'clear'])->name('debitos.clear');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/users/{user}/borrowings', [BorrowingController::class, 'userBorrowings'])->name('users.borrowings');
});

// Usuários (apenas admin pode visualizar, editar, listar usuários)
Route::middleware(['auth', CheckRole::class . ':admin'])->group(function () {
    Route::resource('users', UserController::class)->except(['create', 'store', 'destroy']);
});

Route::middleware('auth')->get('/books', [BookController::class, 'index'])->name('books.index');

Route::middleware(['auth', CheckRole::class . ':admin,bibliotecario'])->group(function () {
    Route::get('/books/create-id-number', [BookController::class, 'createWithId'])->name('books.create.id');
    Route::post('/books/create-id-number', [BookController::class, 'storeWithId'])->name('books.store.id');

    Route::get('/books/create-select', [BookController::class, 'createWithSelect'])->name('books.create.select');
    Route::post('/books/create-select', [BookController::class, 'storeWithSelect'])->name('books.store.select');

    Route::resource('books', BookController::class)->except(['create', 'store', 'show', 'index']);

    Route::resource('authors', AuthorController::class)->except(['show']);
    Route::resource('publishers', PublisherController::class)->except(['show']);
    Route::resource('categories', CategoryController::class)->except(['show']);
});

Route::middleware(['auth', CheckRole::class . ':admin,bibliotecario,cliente'])->group(function () {
    Route::get('books/{book}', [BookController::class, 'show'])->name('books.show');
    Route::get('authors/{author}', [AuthorController::class, 'show'])->name('authors.show');
    Route::get('publishers/{publisher}', [PublisherController::class, 'show'])->name('publishers.show');
    Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');