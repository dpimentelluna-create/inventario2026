
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('auditorias', function (Blueprint $table) {
            $table->id();

            // Usuario que ejecutó la operación.
            // El historial se conserva aunque la cuenta sea eliminada.
            $table->foreignId('usuario_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Copia del nombre para conservar la identidad histórica.
            $table->string('usuario_nombre', 150);

            // Ejemplos: CREAR, ACTUALIZAR, DESACTIVAR.
            $table->string('accion', 50);

            // Ejemplos: USUARIOS, EQUIPOS, PRESTAMOS.
            $table->string('modulo', 50);

            // Descripción legible de lo ocurrido.
            $table->text('descripcion');

            // Tipo e ID del registro afectado.
            $table->string('registro_tipo', 100)->nullable();
            $table->unsignedBigInteger('registro_id')->nullable();

            // Diferencias entre valores anteriores y nuevos.
            $table->json('cambios')->nullable();

            // Información adicional para trazabilidad.
            $table->string('ip', 45)->nullable();
            $table->string('user_agent', 500)->nullable();

            // Esta primera versión registra operaciones exitosas.
            $table->string('resultado', 20)->default('EXITOSO');

            $table->timestamps();

            $table->index(['usuario_id', 'created_at']);
            $table->index(['modulo', 'created_at']);
            $table->index(['accion', 'created_at']);
            $table->index(['registro_tipo', 'registro_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('auditorias');
    }
};
