<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PublisherController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;

// Rota da página inicial
Route::get('/', function () {
    return view('welcome');
});

// Rotas de autenticação
Auth::routes();

// Rota da dashboard
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Rota para o CRUD de categorias
Route::resource('categories', CategoryController::class);
Route::resource('authors', AuthorController::class);
Route::resource('publishers', PublisherController::class);
// Rotas para criação de livros
Route::get('/books/create-id-number', [BookController::class, 'createWithId'])->name('books.create.id');
Route::post('/books/create-id-number', [BookController::class, 'storeWithId'])->name('books.store.id');

Route::get('/books/create-select', [BookController::class, 'createWithSelect'])->name('books.create.select');
Route::post('/books/create-select', [BookController::class, 'storeWithSelect'])->name('books.store.select');

// Rotas RESTful para index, show, edit, update, delete (tem que ficar depois das rotas /books/create-id-number e /books/create-select)
Route::resource('books', BookController::class)->except(['create', 'store']);
