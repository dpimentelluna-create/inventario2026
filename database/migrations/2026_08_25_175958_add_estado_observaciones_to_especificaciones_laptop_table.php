<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('especificaciones_laptop', function (Blueprint $table) {
            $table->enum('estado', [
                'Operativo',
                'Regular',
                'Malogrado',
                'De baja'
            ])->default('Operativo')->after('disco_duro');

            $table->text('observaciones')->nullable()->after('estado');
        });
    }

    public function down(): void
    {
        Schema::table('especificaciones_laptop', function (Blueprint $table) {
            $table->dropColumn(['estado', 'observaciones']);
        });
    }
};