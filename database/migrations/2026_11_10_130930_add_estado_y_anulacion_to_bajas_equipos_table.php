
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bajas_equipos', function (Blueprint $table) {
            $table->string('estado', 20)
                ->default('VIGENTE')
                ->after('observaciones');

            $table->timestamp('anulada_at')
                ->nullable()
                ->after('estado');

            $table->foreignId('anulada_por')
                ->nullable()
                ->after('anulada_at')
                ->constrained('users')
                ->nullOnDelete();

            // Eliminar la restricción que impedía registrar
            // nuevas bajas para un equipo anteriormente dado de baja.
            $table->dropUnique('bajas_equipos_equipo_id_unique');

            // Mantener un índice normal para las consultas por equipo.
            $table->index('equipo_id', 'bajas_equipos_equipo_id_index');
        });
    }

    public function down(): void
    {
        Schema::table('bajas_equipos', function (Blueprint $table) {
            $table->dropForeign(['anulada_por']);
            $table->dropIndex('bajas_equipos_equipo_id_index');

            $table->dropColumn([
                'estado',
                'anulada_at',
                'anulada_por',
            ]);

            $table->unique(
                'equipo_id',
                'bajas_equipos_equipo_id_unique'
            );
        });
    }
};
