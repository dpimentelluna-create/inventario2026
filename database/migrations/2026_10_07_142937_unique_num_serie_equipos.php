<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('equipos', function (Blueprint $table) {
        $table->unique('num_serie');
    });
}

public function down(): void
{
    Schema::table('equipos', function (Blueprint $table) {
        $table->dropUnique(['num_serie']);
    });
}
};