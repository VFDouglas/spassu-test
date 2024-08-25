<?php

namespace App\Http\Controllers;

use App\Models\Assunto;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class AssuntosController extends Controller
{
    public function index(): Factory|View|\Illuminate\Foundation\Application|Application
    {
        return view('assuntos');
    }

    public function buscarAssunto(?int $idAssunto = null): array
    {
        $assuntos = Assunto::query();
        if ($idAssunto) {
            $assuntos->where('id', '=', $idAssunto);
        }
        return $assuntos->get()->toArray();
    }

    public function criarAssunto(): array
    {
        $retorno = [];
        try {
            $userExists = Assunto::query()->where('descricao', request('descricao'))->first();
            if ($userExists) {
                throw new Exception('Já existe um assunto com esta descrição');
            }

            $assunto            = new Assunto();
            $assunto->descricao = request('descricao');
            if (app()->runningUnitTests()) {
                $assunto->id = request('id');
            }
            $assunto->save();

            $retorno['assunto'] = $assunto->toArray();
        } catch (Exception $e) {
            $retorno['erro'] = $e->getMessage();
        }
        return $retorno;
    }

    public function atualizarAssunto(int $id): array
    {
        $retorno = [];
        try {
            $assunto = Assunto::query()->where('id', $id)->first();
            if (!$assunto) {
                throw new Exception('Assunto não encontrado');
            }
            $assunto->descricao = request('descricao');
            $assunto->save();

            $retorno['assunto'] = $assunto->toArray();
        } catch (Exception $e) {
            $retorno['erro'] = $e->getMessage();
        }
        return $retorno;
    }

    public function removerAssunto(int $id): array
    {
        $retorno = [];
        try {
            $assunto = Assunto::query()->where('id', $id)->first();
            if (!$assunto) {
                throw new Exception('Assunto não encontrado');
            }
            $assunto->delete();
            $retorno['assunto'] = $assunto->toArray();
        } catch (Exception $e) {
            $retorno['erro'] = $e->getMessage();
        }
        return $retorno;
    }
}
