<?php

namespace App\Models;

use App\Models\Redis as RedisModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    use HasFactory;

    protected $table = 'autores';

    protected $guarded = [];

    public $timestamps = false;

    public static function buscaAutores(?int $idAutor = null): array
    {
        $redis = new RedisModel();
        $chave = class_basename(get_called_class()) . '_' . __FUNCTION__ . '_' . $idAutor;

        if ($dados = $redis->client->get($chave)) {
            return json_decode($dados, true);
        } else {
            $dados = self::query();
            if ($idAutor) {
                $dados->where('id', '=', $idAutor);
            }
            $dados = $dados->get()->toArray();

            $redis->client->set($chave, json_encode($dados));
            $redis->client->expireAt($chave, time() + 60 * 60);
            return $dados;
        }
    }

    public static function limparCache(?int $idAutor = null): true
    {
        $redis = new RedisModel();
        $redis->excluirCache([
            class_basename(get_called_class()) . 'buscaAutores',
            class_basename(get_called_class()) . 'buscaAutores_' . $idAutor
        ]);

        return true;
    }
}
