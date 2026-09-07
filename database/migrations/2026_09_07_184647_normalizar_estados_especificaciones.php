<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ESPECIFICACIONES DE EQUIPOS
        DB::statement("
            ALTER TABLE especificaciones_equipo
            MODIFY estado ENUM('BUENO', 'REGULAR', 'MALOGRADO')
            NOT NULL DEFAULT 'BUENO'
        ");

        // ESPECIFICACIONES DE LAPTOPS
        DB::statement("
            ALTER TABLE especificaciones_laptop
            MODIFY estado ENUM('BUENO', 'REGULAR', 'MALOGRADO')
            NOT NULL DEFAULT 'BUENO'
        ");
    }

    public function down(): void
    {
        // Restaurar estructura anterior de especificaciones_equipo
        DB::statement("
            ALTER TABLE especificaciones_equipo
            MODIFY estado ENUM('Operativo', 'Regular', 'Malogrado', 'De baja')
            NOT NULL DEFAULT 'Operativo'
        ");

        // Restaurar estructura anterior de especificaciones_laptop
        DB::statement("
            ALTER TABLE especificaciones_laptop
            MODIFY estado ENUM('Bueno', 'Regular', 'Malogrado')
            NOT NULL DEFAULT 'Bueno'
        ");
    }
};