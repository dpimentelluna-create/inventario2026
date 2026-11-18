<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Comprueba si existe un índice por su nombre.
     */
    /**
     * Comprueba si existe un índice por su nombre.
     */
    private function existeIndice(string $nombre): bool
    {
        $resultado = DB::selectOne(
            'SELECT COUNT(*) AS total
         FROM information_schema.statistics
         WHERE table_schema = DATABASE()
         AND table_name = ?
         AND index_name = ?',
            ['bajas_equipos', $nombre]
        );

        return $resultado !== null
            && (int) ($resultado->total ?? 0) > 0;
    }

    /**
     * Comprueba si existe una clave foránea por su nombre.
     */
    private function existeClaveForanea(string $nombre): bool
    {
        $resultado = DB::selectOne(
            'SELECT COUNT(*) AS total
         FROM information_schema.table_constraints
         WHERE constraint_schema = DATABASE()
         AND table_name = ?
         AND constraint_name = ?
         AND constraint_type = ?',
            ['bajas_equipos', $nombre, 'FOREIGN KEY']
        );

        return $resultado !== null
            && (int) ($resultado->total ?? 0) > 0;
    }


    public function up(): void
    {
        // 1. Crear estado si todavía no existe.
        if (!Schema::hasColumn('bajas_equipos', 'estado')) {
            Schema::table('bajas_equipos', function (Blueprint $table) {
                $table->string('estado', 20)
                    ->default('VIGENTE')
                    ->after('observaciones');
            });
        }

        // 2. Crear fecha de anulación si no existe.
        if (!Schema::hasColumn('bajas_equipos', 'anulada_at')) {
            Schema::table('bajas_equipos', function (Blueprint $table) {
                $table->timestamp('anulada_at')
                    ->nullable()
                    ->after('estado');
            });
        }

        // 3. Crear usuario que anuló si no existe.
        if (!Schema::hasColumn('bajas_equipos', 'anulada_por')) {
            Schema::table('bajas_equipos', function (Blueprint $table) {
                $table->unsignedBigInteger('anulada_por')
                    ->nullable()
                    ->after('anulada_at');
            });
        }

        // 4. Crear clave foránea si todavía no existe.
        if (
            !$this->existeClaveForanea(
                'bajas_equipos_anulada_por_foreign'
            )
        ) {
            Schema::table('bajas_equipos', function (Blueprint $table) {
                $table->foreign('anulada_por', 'bajas_equipos_anulada_por_foreign')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            });
        }

        // 5. Crear primero el índice normal.
        if (!$this->existeIndice('bajas_equipos_equipo_id_index')) {
            Schema::table('bajas_equipos', function (Blueprint $table) {
                $table->index(
                    'equipo_id',
                    'bajas_equipos_equipo_id_index'
                );
            });
        }

        // 6. Eliminar el índice único anterior.
        if ($this->existeIndice('bajas_equipos_equipo_id_unique')) {
            Schema::table('bajas_equipos', function (Blueprint $table) {
                $table->dropUnique('bajas_equipos_equipo_id_unique');
            });
        }
    }

    public function down(): void
    {
        // No ejecutar rollback sin revisar previamente
        // los registros históricos y posibles duplicados.
        throw new RuntimeException(
            'Esta migración requiere una revisión manual antes de revertirse.'
        );
    }
};
