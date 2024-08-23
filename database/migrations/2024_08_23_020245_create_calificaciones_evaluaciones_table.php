<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalificacionesEvaluacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calificaciones_evaluaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evaluador_id');
            $table->unsignedBigInteger('user_id');
            $table->string('nombre_usuario');
            $table->string('matricula');
            $table->unsignedBigInteger('estandar_id');
            $table->string('evidencias')->nullable(); // Calificación de evidencias
            $table->string('evaluacion')->nullable(); // Calificación de evaluación
            $table->string('presentacion')->nullable(); // Calificación de presentación
            $table->timestamps();

            // Definimos las claves foráneas
            $table->foreign('evaluador_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('estandar_id')->references('id')->on('estandares')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calificaciones_evaluaciones');
    }
}
