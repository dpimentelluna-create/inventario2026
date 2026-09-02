<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestamo_accesorios', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('prestamo_equipo_id');
            $table->foreign('prestamo_equipo_id')
                ->references('id')
                ->on('prestamo_equipos')
                ->onDelete('cascade');

            $table->unsignedBigInteger('accesorio_equipo_id');
            $table->foreign('accesorio_equipo_id')
                ->references('id')
                ->on('accesorios_equipo')
                ->onDelete('cascade');

            $table->enum('estado', [
                'REGULAR',
                'BUENO',
                'MALOGRADO'
            ]);

            $table->text('observacion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamo_accesorios');
    }
};