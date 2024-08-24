<?php

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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
};
