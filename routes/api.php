<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksControllerApi;

Route::apiResource('books', BooksControllerApi::class);
