<?php

use App\Models\LivroAutor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const TABLE = 'livro_autor';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable(self::TABLE)) {
            return;
        }
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->foreignId('livro_id')->constrained('livros')->cascadeOnDelete();
            $table->foreignId('autor_id')->constrained('autores')->cascadeOnDelete();
            $table->unique(['livro_id', 'autor_id']);
        });
        LivroAutor::query()
            ->insert([
                [
                    'livro_id' => 1,
                    'autor_id' => 3,
                ],
                [
                    'livro_id' => 2,
                    'autor_id' => 2,
                ],
                [
                    'livro_id' => 3,
                    'autor_id' => 4,
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
