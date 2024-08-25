<?php

namespace App\Exports;

use App\Models\Livro;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class LivrosExport implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        return Livro::query()
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
            ->leftJoin('livro_assunto as las', 'l.id', '=', 'las.livro_id')
            ->groupBy(['l.id', 'l.titulo', 'l.editora', 'l.edicao', 'l.ano', 'l.valor', 'las.assunto_id'])
            ->get();
    }
}
