<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;

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
