<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('fechas_horarios_elegidos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('fecha_competencia_id')->constrained('fechas_competencias')->onDelete('cascade'); // Ajusta el nombre de la tabla aquí
            $table->foreignId('horario_competencia_id')->constrained('horarios_competencias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fechas_horarios_elegidos');
    }
};
