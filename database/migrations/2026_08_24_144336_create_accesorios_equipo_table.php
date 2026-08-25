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
        Schema::create('accesorios_equipo', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('equipo_id');
        $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('cascade');
        $table->enum('tipo', ['Batería','Cargador']);
        $table->string('marca', 80)->nullable();
        $table->string('num_serie', 100)->nullable();
        $table->enum('estado', ['Operativo','Regular','Malogrado'])->default('Operativo');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accesorios_equipo');
    }
};
