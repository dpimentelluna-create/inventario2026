<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prestamo_equipos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('prestamo_id');
            $table->foreign('prestamo_id')
                ->references('id')
                ->on('prestamos')
                ->onDelete('cascade');

            $table->unsignedBigInteger('equipo_id');
            $table->foreign('equipo_id')
                ->references('id')
                ->on('equipos')
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
        Schema::dropIfExists('prestamo_equipos');
    }
};