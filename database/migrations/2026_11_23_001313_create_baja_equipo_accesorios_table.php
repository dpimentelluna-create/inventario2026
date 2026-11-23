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
        Schema::create('baja_equipo_accesorios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('baja_equipo_id')
                ->constrained('bajas_equipos')
                ->restrictOnDelete();

            $table->foreignId('accesorio_equipo_id')
                ->constrained('accesorios_equipo')
                ->restrictOnDelete();

            $table->timestamps();

            $table->unique(
                ['baja_equipo_id', 'accesorio_equipo_id'],
                'baja_equipo_accesorios_unico'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('baja_equipo_accesorios');
    }
};