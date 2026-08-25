<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('especificaciones_laptop', function (Blueprint $table) {
            $table->string('color', 50)->nullable()->after('disco_duro');
        });
    }

    public function down(): void
    {
        Schema::table('especificaciones_laptop', function (Blueprint $table) {
            $table->dropColumn('color');
        });
    }
};