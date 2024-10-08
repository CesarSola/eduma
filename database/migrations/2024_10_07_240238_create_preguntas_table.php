<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePreguntasTable extends Migration
{
    public function up()
    {
        Schema::create('preguntas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo'); // Título del elemento (ej: "La carta descriptiva elaborada")
            $table->string('pregunta'); // Pregunta específica (ej: "¿Se presenta en formato digital y/o impreso?")
            $table->string('resp_correcta'); // Respuesta correcta
            $table->foreignId('autodiagnostico_id')->constrained('autodiagnosticos')->onDelete('cascade'); // Relación con autodiagnósticos
            $table->foreignId('elemento_id')->constrained('elementos')->onDelete('cascade'); // Relación con elementos
            $table->foreignId('criterio_id')->nullable()->constrained('criterios')->onDelete('cascade'); // Relación con criterios (puede ser opcional)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('preguntas');
    }
}
