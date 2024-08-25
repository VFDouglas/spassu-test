<?php

use App\Models\Assunto;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    private const TABLE = 'assuntos';

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
            $table->string('descricao', 20);
        });
        Assunto::query()
            ->insert([
                [
                    'id'        => 1,
                    'descricao' => 'Ficcão',
                ],
                [
                    'id'        => 2,
                    'descricao' => 'Romance',
                ],
                [
                    'id'        => 3,
                    'descricao' => 'Biografia',
                ],
                [
                    'id'        => 4,
                    'descricao' => 'Terror',
                ],
                [
                    'id'        => 5,
                    'descricao' => 'Aventura',
                ],
                [
                    'id'        => 6,
                    'descricao' => 'Infantil',
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
