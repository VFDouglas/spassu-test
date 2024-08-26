<?php

namespace App\Models;

use App\Models\Redis as RedisModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
    use HasFactory;

    protected $table = 'livros';

    protected $guarded = [];

    public $timestamps = false;

    public static function buscarLivros(?int $idLivro = null): array
    {
        $redis = new RedisModel();
        $chave = class_basename(get_called_class()) . '_' . __FUNCTION__ . '_' . $idLivro;

        if ($dados = $redis->client->get($chave)) {
            return json_decode($dados, true);
        } else {
            $dados = self::query()
                ->select([
                    'l.id',
                    'l.titulo',
                    'l.editora',
                    'l.edicao',
                    'l.ano',
                    'l.valor',
                    'las.assunto_id',
                ])
                ->selectRaw("GROUP_CONCAT(lat.autor_id ORDER BY lat.autor_id SEPARATOR ',') AS autor_id")
                ->from('livros as l')
                ->leftJoin('livro_autor as lat', 'l.id', '=', 'lat.livro_id')
                ->leftJoin('livro_assunto as las', 'l.id', '=', 'las.livro_id');
            if ($idLivro) {
                $dados->where('id', '=', $idLivro);
            }
            $dados->groupBy(['l.id', 'l.titulo', 'l.editora', 'l.edicao', 'l.ano', 'l.valor', 'las.assunto_id']);
            $dados = $dados->get()->toArray();

            $redis->client->set($chave, json_encode($dados));
            $redis->client->expireAt($chave, time() + 60 * 60);
            return $dados;
        }
    }

    public static function limparCache(?int $idLivro = null): true
    {
        $redis = new RedisModel();
        $redis->excluirCache([
            class_basename(get_called_class()) . '_buscarLivros',
            class_basename(get_called_class()) . '_buscarLivros_' . $idLivro
        ]);

        return true;
    }
}
