<?php

namespace App\Http\Controllers;

use App\Exports\LivrosExport;
use App\Models\Assunto;
use App\Models\Autor;
use App\Models\Livro;
use App\Models\LivroAssunto;
use App\Models\LivroAutor;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class LivrosController extends Controller
{
    public function index(): Factory|View|\Illuminate\Foundation\Application|Application
    {
        return view('livros', [
            'assuntos' => Assunto::buscaAssuntos(),
            'autores'  => Autor::buscaAutores(),
        ]);
    }

    public function exportar(): BinaryFileResponse
    {
        return Excel::download(new LivrosExport(), 'livros.xlsx');
    }

    public function buscarLivro(?int $idLivro = null): array
    {
        return Livro::buscarLivros($idLivro);
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
            if (app()->runningUnitTests()) {
                $livro->id = request('id');
            }
            $livro->save();

            if (request('autor_id')) {
                foreach (request('autor_id') as $autor_id) {
                    LivroAutor::query()
                        ->create([
                            'livro_id' => $livro->id,
                            'autor_id' => (int)$autor_id,
                        ]);
                }
            }
            if (request('assunto_id')) {
                LivroAssunto::query()
                    ->create([
                        'livro_id'   => $livro->id,
                        'assunto_id' => (int)request('assunto_id'),
                    ]);
            }

            $retorno['livro'] = $livro->toArray();
            Livro::limparCache($livro->id);
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

            LivroAutor::query()->where('livro_id', '=', $livro->id)->delete();
            if (request('autor_id')) {
                foreach (request('autor_id') as $autor_id) {
                    if (!$autor_id) {
                        continue;
                    }
                    LivroAutor::query()
                        ->updateOrInsert([
                            'livro_id' => $livro->id,
                            'autor_id' => (int)$autor_id,
                        ], [
                            'livro_id' => $livro->id,
                        ]);
                }
            }
            LivroAssunto::query()->where('livro_id', '=', $livro->id)->delete();
            if (!empty(request('assunto_id'))) {
                LivroAssunto::query()
                    ->updateOrInsert([
                        'livro_id'   => $livro->id,
                        'assunto_id' => (int)request('assunto_id'),
                    ], [
                        'livro_id' => $livro->id,
                    ]);
            }

            $retorno['livro'] = $livro->toArray();
            Livro::limparCache($livro->id);
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
            Livro::limparCache($id);
        } catch (Exception $e) {
            $retorno['erro'] = $e->getMessage();
        }
        return $retorno;
    }
}
