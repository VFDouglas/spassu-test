<?php

use App\Models\Assunto;
use App\Models\LivroAssunto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const TABLE = 'livro_assunto';

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
            $table->foreignId('assunto_id')->constrained('assuntos')->cascadeOnDelete();
            $table->unique(['livro_id', 'assunto_id']);
        });
        LivroAssunto::query()
            ->insert([
                [
                    'livro_id' => 1,
                    'assunto_id' => 1,
                ],
                [
                    'livro_id' => 2,
                    'assunto_id' => 2,
                ],
                [
                    'livro_id' => 3,
                    'assunto_id' => 3,
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
