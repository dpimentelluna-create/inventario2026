<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::table('equipos', function (Blueprint $table) {
        // Los campos ya fueron eliminados anteriormente.
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
        $table->string('codigo_inventario', 50)->nullable();

        $table->enum('estado', [
            'Bueno',
            'Regular',
            'Malogrado'
        ])->default('Regular');

        $table->text('observacion')->nullable();
    });
    }
};
