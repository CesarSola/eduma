<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateElementosTable extends Migration
{
    public function up()
    {
        Schema::create('elementos', function (Blueprint $table) {
            $table->id(); // ID único para cada elemento
            $table->unsignedBigInteger('autodiagnostico_id'); // Relación con el autodiagnóstico
            $table->string('nombre'); // Nombre del elemento
            $table->timestamps();

            // Definimos la clave foránea
            $table->foreign('autodiagnostico_id')->references('id')->on('autodiagnosticos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('elementos');
    }
}
