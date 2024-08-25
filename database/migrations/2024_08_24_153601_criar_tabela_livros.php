<?php

use App\Models\Livro;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const TABLE = 'livros';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable(self::TABLE)) {
            return;
        }
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string('titulo', 40);
            $table->string('editora', 40);
            $table->integer('edicao');
            $table->string('ano', 4);
            $table->float('valor');
        });
        Livro::query()
            ->insert([
                [
                    'id'      => 1,
                    'titulo'  => 'As Crônicas de Um Mundo Perdido',
                    'editora' => 'Nova Era',
                    'edicao'  => 1,
                    'ano'     => '2022',
                    'valor'   => 59.80,
                ],
                [
                    'id'      => 2,
                    'titulo'  => 'O enigma das estrelas',
                    'editora' => 'Aurora',
                    'edicao'  => 1,
                    'ano'     => '2019',
                    'valor'   => 45.90,
                ],
                [
                    'id'      => 3,
                    'titulo'  => 'A Jornada do Herói',
                    'editora' => 'Livros do Amanhã',
                    'edicao'  => 1,
                    'ano'     => '2021',
                    'valor'   => 52.50,
                ],
            ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
};
