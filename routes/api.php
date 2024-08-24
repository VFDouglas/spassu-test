<?php

use App\Http\Controllers\AssuntosController;
use App\Http\Controllers\AutoresController;
use App\Http\Controllers\LivrosController;
use Illuminate\Support\Facades\Route;

Route::controller(LivrosController::class)->group(function () {
    Route::get('/livros/{livro?}', 'buscarLivro');
    Route::post('/livros', 'criarLivro');
    Route::put('/livros/{livro}', 'atualizarLivro');
    Route::delete('/livros/{livro}', 'removerLivro');
});

Route::controller(AssuntosController::class)->group(function () {
    Route::get('/assuntos/{assunto?}', 'buscarAssunto');
    Route::post('/assuntos', 'criarAssunto');
    Route::put('/assuntos/{assunto}', 'atualizarAssunto');
    Route::delete('/assuntos/{assunto}', 'removerAssunto');
});

Route::controller(AutoresController::class)->group(function () {
    Route::get('/autores/{autor?}', 'buscarAutor');
    Route::post('/autores', 'criarAutor');
    Route::put('/autores/{autor}', 'atualizarAutor');
    Route::delete('/autores/{autor}', 'removerAutor');
});
