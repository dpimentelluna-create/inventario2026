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
         Schema::create('especificaciones_equipo', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('equipo_id');

        $table->text('descripcion')->nullable();

        $table->string('color', 50)->nullable();

        $table->enum('estado', [
            'Operativo',
            'Regular',
            'Malogrado',
            'De baja'
        ])->default('Operativo');

        $table->text('observaciones')->nullable();

        $table->timestamps();

        $table->foreign('equipo_id')
            ->references('id')
            ->on('equipos')
            ->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especificaciones_equipo');
    }
};
