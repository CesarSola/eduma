<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRespAutDiagTable extends Migration
{
    public function up()
    {
        Schema::create('resp_aut_diag', function (Blueprint $table) {
            $table->id(); // Campo ID
            $table->foreignId('usuario_id')->constrained('users'); // ID del usuario
            $table->foreignId('estandar_id')->constrained('estandares'); // ID del estándar
            $table->foreignId('autodiagnostico_id')->constrained('autodiagnosticos'); // ID del autodiagnóstico
            $table->foreignId('elemento_id')->constrained('elementos'); // ID del elemento
            $table->foreignId('criterio_id')->constrained('criterios'); // ID del criterio
            $table->foreignId('pregunta_id')->constrained('preguntas'); // ID de la pregunta
            $table->enum('respuesta', ['si', 'no']); // Respuesta del usuario
            $table->boolean('correcta')->nullable(); // Indica si la respuesta es correcta o no
            $table->timestamps(); // Campos de timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('resp_aut_diag');
    }
}
