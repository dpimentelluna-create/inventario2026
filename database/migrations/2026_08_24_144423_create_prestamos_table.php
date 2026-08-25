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
        Schema::create('prestamos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('equipo_id');
        $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('cascade');
        $table->unsignedBigInteger('docente_id');
        $table->foreign('docente_id')->references('id')->on('docentes')->onDelete('cascade');
        $table->unsignedBigInteger('ubicacion_destino_id')->nullable();
        $table->foreign('ubicacion_destino_id')->references('id')->on('ubicaciones')->onDelete('set null');
        $table->date('fecha_entrega');
        $table->date('fecha_devolucion_prevista')->nullable();
        $table->date('fecha_devolucion_real')->nullable();
        $table->enum('estado', ['Prestado','Devuelto','Vencido'])->default('Prestado');
        $table->text('observacion')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
