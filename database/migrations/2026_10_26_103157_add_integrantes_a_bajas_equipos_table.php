
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bajas_equipos', function (Blueprint $table) {
            $table->json('entregantes')->nullable();
            $table->json('receptores')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('bajas_equipos', function (Blueprint $table) {
            $table->dropColumn(['entregantes', 'receptores']);
        });
    }
};
