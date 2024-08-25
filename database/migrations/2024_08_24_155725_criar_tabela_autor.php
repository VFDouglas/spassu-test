<?php

use App\Models\Autor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const TABLE = 'autores';

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
            $table->string('nome', 40);
        });
        Autor::query()
            ->insert([
                [
                    'id'   => 1,
                    'nome' => 'Douglas Vicentini',
                ],
                [
                    'id'   => 2,
                    'nome' => 'João Silva',
                ],
                [
                    'id'   => 3,
                    'nome' => 'Maria Fernandes',
                ],
                [
                    'id'   => 4,
                    'nome' => 'Carlos Pereira',
                ],
                [
                    'id'   => 5,
                    'nome' => 'Ana Costa',
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
