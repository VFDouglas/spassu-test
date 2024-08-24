<?php

use App\Http\Controllers\AssuntosController;
use App\Http\Controllers\AutoresController;
use App\Http\Controllers\LivrosController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::controller(LivrosController::class)->group(function () {
    Route::get('/livros', 'index');
});

Route::controller(AssuntosController::class)->group(function () {
    Route::get('/assuntos', 'index');
});

Route::controller(AutoresController::class)->group(function () {
    Route::get('/autores', 'index');
});
