<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAutoDiagsTable extends Migration
{
    public function up()
    {
        Schema::create('autodiagnosticos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->unsignedBigInteger('estandar_id'); // Asegúrate de que esto coincida con el tipo de id de estandars
            $table->foreign('estandar_id')->references('id')->on('estandares')->onDelete('cascade'); // Clave foránea
            $table->integer('elementos')->unsigned(); // Para almacenar el número de elementos
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('autodiagnosticos');
    }
}
