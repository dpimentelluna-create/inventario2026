
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->enum('situacion_administrativa', [
                'EN_INVENTARIO',
                'DE_BAJA'
            ])->default('EN_INVENTARIO')
              ->after('fecha_registro');
        });
    }

    public function down(): void
    {
        Schema::table('equipos', function (Blueprint $table) {
            $table->dropColumn('situacion_administrativa');
        });
    }
};