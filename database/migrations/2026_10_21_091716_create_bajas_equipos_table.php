
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bajas_equipos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('equipo_id')
                ->unique()
                ->constrained('equipos')
                ->restrictOnDelete();

            $table->date('fecha');
            $table->string('destino', 150);
            $table->string('quien_entrego', 150);
            $table->string('quien_recibio', 150);
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bajas_equipos');
    }
};