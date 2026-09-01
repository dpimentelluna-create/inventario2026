<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accesorios_equipo', function (Blueprint $table) {
            $table->string('tipo', 100)->change();
        });
    }

    public function down(): void
    {
        Schema::table('accesorios_equipo', function (Blueprint $table) {
            $table->enum('tipo', ['Batería', 'Cargador'])->change();
        });
    }
};