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
        Schema::create('docentes', function (Blueprint $table) {
        $table->id();
        $table->string('nombres', 100);
        $table->string('apellidos', 100);
        $table->string('cargo', 100)->default('Docente');;
        $table->string('dni', 8)->unique()->nullable();
        $table->string('correo', 150)->nullable();
        $table->string('celular', 20)->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
