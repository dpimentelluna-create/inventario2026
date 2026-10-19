<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('rol', 20)->default('consulta')->after('password');
            $table->boolean('activo')->default(true)->after('rol');
            $table->boolean('debe_cambiar_password')->default(false)->after('activo');
        });

        // Las cuentas que ya existen quedan como registrador
        DB::table('users')->update(['rol' => 'registrador']);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['rol', 'activo', 'debe_cambiar_password']);
        });
    }
};