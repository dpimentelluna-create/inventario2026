
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accesorios_equipo', function (Blueprint $table) {
            // Retirar temporalmente la llave foránea actual.
            $table->dropForeign('accesorios_equipo_equipo_id_foreign');

            // Permitir accesorios sin equipo asociado.
            $table->unsignedBigInteger('equipo_id')->nullable()->change();

            // Conservar el accesorio si se elimina físicamente su equipo.
            $table->foreign('equipo_id')
                ->references('id')
                ->on('equipos')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        // Evitar perder información si existen accesorios independientes.
        if (DB::table('accesorios_equipo')->whereNull('equipo_id')->exists()) {
            throw new RuntimeException(
                'No se puede revertir esta migración: existen accesorios sin equipo asociado.'
            );
        }

        Schema::table('accesorios_equipo', function (Blueprint $table) {
            $table->dropForeign('accesorios_equipo_equipo_id_foreign');

            $table->unsignedBigInteger('equipo_id')->nullable(false)->change();

            $table->foreign('equipo_id')
                ->references('id')
                ->on('equipos')
                ->cascadeOnDelete();
        });
    }
};
