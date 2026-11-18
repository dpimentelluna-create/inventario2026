<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('accesorios_equipo', function (Blueprint $table) {
            $table->string('modelo', 100)
                ->nullable()
                ->after('marca');
        });
    }

    public function down(): void
    {
        Schema::table('accesorios_equipo', function (Blueprint $table) {
            $table->dropColumn('modelo');
        });
    }
};
