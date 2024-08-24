<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use App\Models\LivroAutor;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class LivrosController extends Controller
{
    public function index(): Factory|View|\Illuminate\Foundation\Application|Application
    {
        return view('livros', [
            'assuntos' => Assunto::query()->get()->toArray(),
            'autores'  => Autor::query()->get()->toArray(),
        ]);
    }

    public function buscarLivro(?int $idLivro = null): array
    {
        $livros = Livro::query();
        if ($idLivro) {
            $livros->where('id', '=', $idLivro);
        }
        return $livros->get()->toArray();
    }

    public function criarLivro(): array
    {
        $retorno = [];
        try {
            $userExists = Livro::query()->where('titulo', request('titulo'))->first();
            if ($userExists) {
                throw new Exception('Já existe um livro com este título');
            }

            $livro          = new Livro();
            $livro->titulo  = request('titulo');
            $livro->editora = request('editora');
            $livro->edicao  = request('edicao');
            $livro->ano     = request('ano');
            $livro->valor   = request('valor');
            $livro->save();

            if (request('autor_id')) {
                $livroAutor = LivroAutor::query()
                    ->create([
                        'livro_id' => $livro->id,
                        'autor_id' => (int)request('autor_id'),
                    ]);
            }
            if (request('assunto_id')) {
                $livroAutor = LivroAssunto::query()
                    ->create([
                        'livro_id'   => $livro->id,
                        'assunto_id' => (int)request('assunto_id'),
                    ]);
            }

            $retorno['livro'] = $livro->toArray();
        } catch (Exception $e) {
            $retorno['erro'] = $e->getMessage();
        }
        return $retorno;
    }

    public function atualizarLivro(int $id): array
    {
        $retorno = [];
        try {
            $livro = Livro::query()->where('id', $id)->first();
            if (!$livro) {
                throw new Exception('Livro não encontrado');
            }
            $livro->titulo  = request('titulo');
            $livro->editora = request('editora');
            $livro->edicao  = request('edicao');
            $livro->ano     = request('ano');
            $livro->valor   = request('valor');
            $livro->save();

            if (request('autor_id')) {
                $livroAutor = LivroAutor::query()
                    ->updateOrInsert([
                        'livro_id' => $livro->id,
                        'autor_id' => (int)request('autor_id'),
                    ], [
                        'livro_id' => $livro->id,
                    ]);
            }
            if (request('assunto_id')) {
                $livroAutor = LivroAssunto::query()
                    ->updateOrInsert([
                        'livro_id'   => $livro->id,
                        'assunto_id' => (int)request('assunto_id'),
                    ], [
                        'livro_id' => $livro->id,
                    ]);
            }

            $retorno['livro'] = $livro->toArray();
        } catch (Exception $e) {
            $retorno['erro'] = $e->getMessage();
        }
        return $retorno;
    }

    public function removerLivro(int $id): array
    {
        $retorno = [];
        try {
            $livro = Livro::query()->where('id', $id)->first();
            if (!$livro) {
                throw new Exception('Livro não encontrado');
            }
            $livro->delete();
            $retorno['livro'] = $livro->toArray();
        } catch (Exception $e) {
            $retorno['erro'] = $e->getMessage();
        }
        return $retorno;
    }
}
