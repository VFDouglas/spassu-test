<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class AutoresController extends Controller
{
    public function index(): Factory|View|\Illuminate\Foundation\Application|Application
    {
        return view('autores');
    }

    public function buscarAutor(?int $idAutor = null): array
    {
        $autores = Autor::query();
        if ($idAutor) {
            $autores->where('id', '=', $idAutor);
        }
        return $autores->get()->toArray();
    }

    public function criarAutor(): array
    {
        $retorno = [];
        try {
            $userExists = Autor::query()->where('nome', request('nome'))->first();
            if ($userExists) {
                throw new Exception('Já existe um autor com este nome');
            }

            $autor       = new Autor();
            $autor->nome = request('nome');
            if (app()->runningUnitTests()) {
                $autor->id = request('id');
            }
            $autor->save();

            $retorno['autor'] = $autor->toArray();
        } catch (Exception $e) {
            $retorno['erro'] = $e->getMessage();
        }
        return $retorno;
    }

    public function atualizarAutor(int $id): array
    {
        $retorno = [];
        try {
            $autor = Autor::query()->where('id', $id)->first();
            if (!$autor) {
                throw new Exception('Autor não encontrado');
            }
            $autor->nome = request('nome');
            $autor->save();

            $retorno['autor'] = $autor->toArray();
        } catch (Exception $e) {
            $retorno['erro'] = $e->getMessage();
        }
        return $retorno;
    }

    public function removerAutor(int $id): array
    {
        $retorno = [];
        try {
            $autor = Autor::query()->where('id', $id)->first();
            if (!$autor) {
                throw new Exception('Autor não encontrado');
            }
            $autor->delete();
            $retorno['autor'] = $autor->toArray();
        } catch (Exception $e) {
            $retorno['erro'] = $e->getMessage();
        }
        return $retorno;
    }
}
