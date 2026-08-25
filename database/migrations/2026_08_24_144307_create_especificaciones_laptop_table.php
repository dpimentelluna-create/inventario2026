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
        Schema::create('especificaciones_laptop', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('equipo_id');
        $table->foreign('equipo_id')->references('id')->on('equipos')->onDelete('cascade');
        $table->string('procesador', 100)->nullable();
        $table->string('ram', 30)->nullable();
        $table->string('disco_duro', 30)->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('especificaciones_laptop');
    }
};
