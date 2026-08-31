<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Primero permitir los nuevos estados
        DB::statement("
            ALTER TABLE especificaciones_laptop
            MODIFY estado ENUM('Bueno', 'Regular', 'Malogrado', 'Operativo', 'De baja')
            NOT NULL DEFAULT 'Regular'
        ");

        DB::statement("
            ALTER TABLE especificaciones_equipo
            MODIFY estado ENUM('Bueno', 'Regular', 'Malogrado', 'Operativo', 'De baja')
            NOT NULL DEFAULT 'Regular'
        ");

        DB::statement("
            ALTER TABLE accesorios_equipo
            MODIFY estado ENUM('Bueno', 'Regular', 'Malogrado', 'Operativo', 'De baja')
            NOT NULL DEFAULT 'Regular'
        ");

        // 2. Ahora convertir los estados antiguos
        DB::table('especificaciones_laptop')
            ->where('estado', 'Operativo')
            ->update(['estado' => 'Bueno']);

        DB::table('especificaciones_laptop')
            ->where('estado', 'De baja')
            ->update(['estado' => 'Malogrado']);

        DB::table('accesorios_equipo')
            ->where('estado', 'Operativo')
            ->update(['estado' => 'Bueno']);

        // 3. Finalmente dejar solamente los 3 estados definitivos
        DB::statement("
            ALTER TABLE especificaciones_laptop
            MODIFY estado ENUM('Bueno', 'Regular', 'Malogrado')
            NOT NULL DEFAULT 'Regular'
        ");

        DB::statement("
            ALTER TABLE especificaciones_equipo
            MODIFY estado ENUM('Bueno', 'Regular', 'Malogrado')
            NOT NULL DEFAULT 'Regular'
        ");

        DB::statement("
            ALTER TABLE accesorios_equipo
            MODIFY estado ENUM('Bueno', 'Regular', 'Malogrado')
            NOT NULL DEFAULT 'Regular'
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE especificaciones_laptop
            MODIFY estado ENUM('Operativo', 'Regular', 'Malogrado', 'De baja')
            NOT NULL DEFAULT 'Operativo'
        ");

        DB::statement("
            ALTER TABLE especificaciones_equipo
            MODIFY estado ENUM('Operativo', 'Regular', 'Malogrado', 'De baja')
            NOT NULL DEFAULT 'Operativo'
        ");

        DB::statement("
            ALTER TABLE accesorios_equipo
            MODIFY estado ENUM('Operativo', 'Regular', 'Malogrado')
            NOT NULL DEFAULT 'Operativo'
        ");
    }
};