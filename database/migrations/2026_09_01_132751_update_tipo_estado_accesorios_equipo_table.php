<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Permitir cualquier tipo de accesorio
        DB::statement("
            ALTER TABLE accesorios_equipo
            MODIFY tipo VARCHAR(100) NOT NULL
        ");

        // Actualizar los estados disponibles
        DB::statement("
            ALTER TABLE accesorios_equipo
            MODIFY estado ENUM('Bueno', 'Regular', 'Malogrado')
            NOT NULL DEFAULT 'Regular'
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restaurar el tipo original
        DB::statement("
            ALTER TABLE accesorios_equipo
            MODIFY tipo ENUM('Batería', 'Cargador')
            NOT NULL
        ");

        // Restaurar los estados originales
        DB::statement("
            ALTER TABLE accesorios_equipo
            MODIFY estado ENUM('Operativo', 'Regular', 'Malogrado')
            NOT NULL DEFAULT 'Operativo'
        ");
    }
};