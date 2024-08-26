<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Redis as RedisModel;

class Assunto extends Model
{
    use HasFactory;

    protected $table = 'assuntos';

    protected $guarded = [];

    public $timestamps = false;

    public static function buscaAssuntos(?int $idAssunto = null): array
    {
        $redis = new RedisModel();
        $chave = class_basename(get_called_class()) . '_' . __FUNCTION__ . '_' . $idAssunto;

        if ($dados = $redis->client->get($chave)) {
            return json_decode($dados, true);
        } else {
            $dados = self::query();
            if ($idAssunto) {
                $dados->where('id', '=', $idAssunto);
            }
            $dados = $dados->get()->toArray();

            $redis->client->set($chave, json_encode($dados));
            $redis->client->expireAt($chave, time() + 60 * 60);
            return $dados;
        }
    }

    public static function limparCache(?int $idAssunto = null): true
    {
        $redis = new RedisModel();
        $redis->excluirCache([
            class_basename(get_called_class()) . '_buscaAssuntos',
            class_basename(get_called_class()) . '_buscaAssuntos_' . $idAssunto
        ]);

        return true;
    }
}
