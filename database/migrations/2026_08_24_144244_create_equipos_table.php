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
        Schema::create('equipos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('tipo_equipo_id');
        $table->foreign('tipo_equipo_id')->references('id')->on('tipos_equipo')->onDelete('cascade');
        $table->string('marca', 80);
        $table->string('modelo', 100)->nullable();
        $table->string('num_serie', 100)->nullable();
        $table->string('codigo_inventario', 50)->nullable();
        $table->enum('estado', ['Nuevo','Operativo','Regular','Malogrado','De baja'])->default('Operativo');
        $table->unsignedBigInteger('ubicacion_id');
        $table->foreign('ubicacion_id')->references('id')->on('ubicaciones')->onDelete('cascade');
        $table->date('fecha_registro');
        $table->text('observacion')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};
