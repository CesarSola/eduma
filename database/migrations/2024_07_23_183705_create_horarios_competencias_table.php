<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHorariosCompetenciasTable extends Migration
{
    public function up()
    {
        Schema::create('horarios_competencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('competencia_id');
            $table->foreign('competencia_id')->references('id')->on('estandares')->onDelete('cascade');
            $table->foreignId('fecha_competencia_id')->constrained('fechas_competencias')->onDelete('cascade');
            $table->time('hora'); // Almacena la hora
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('horarios_competencias');
    }
}
