<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accesorios_equipo', function (Blueprint $table) {
            $table->foreignId('ubicacion_id')
                ->nullable()
                ->after('equipo_id')
                ->constrained('ubicaciones')
                ->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('accesorios_equipo', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ubicacion_id');
        });
    }
};