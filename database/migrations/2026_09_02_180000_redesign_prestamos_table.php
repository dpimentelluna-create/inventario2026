<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Primero eliminamos las columnas antiguas
        Schema::table('prestamos', function (Blueprint $table) {

            $table->dropForeign(['equipo_id']);
            $table->dropColumn('equipo_id');

            $table->dropForeign(['ubicacion_destino_id']);
            $table->dropColumn('ubicacion_destino_id');

            $table->dropColumn([
                'fecha_devolucion_prevista',
                'fecha_devolucion_real',
                'observacion',
                'fecha_entrega',
                'estado'
            ]);
        });

        // Después agregamos las nuevas columnas
        Schema::table('prestamos', function (Blueprint $table) {

            $table->string('cargo', 100)
                ->default('DOCENTE');

            $table->date('fecha');

            $table->time('hora_inicio');

            $table->time('hora_fin')
                ->nullable();

            $table->enum('estado', [
                'ACTIVO',
                'TERMINADO'
            ])->default('ACTIVO');
        });
    }

    public function down(): void
    {
        Schema::table('prestamos', function (Blueprint $table) {

            $table->unsignedBigInteger('equipo_id');

            $table->foreign('equipo_id')
                ->references('id')
                ->on('equipos')
                ->onDelete('cascade');

            $table->unsignedBigInteger('ubicacion_destino_id')
                ->nullable();

            $table->foreign('ubicacion_destino_id')
                ->references('id')
                ->on('ubicaciones')
                ->onDelete('set null');

            $table->date('fecha_entrega');

            $table->date('fecha_devolucion_prevista')
                ->nullable();

            $table->date('fecha_devolucion_real')
                ->nullable();

            $table->text('observacion')
                ->nullable();

            $table->dropColumn([
                'cargo',
                'fecha',
                'hora_inicio',
                'hora_fin',
                'estado'
            ]);
        });

        Schema::table('prestamos', function (Blueprint $table) {
            $table->enum('estado', [
                'Prestado',
                'Devuelto',
                'Vencido'
            ])->default('Prestado');
        });
    }
};