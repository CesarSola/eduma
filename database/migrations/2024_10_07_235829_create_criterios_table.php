<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriteriosTable extends Migration
{
    public function up()
    {
        Schema::create('criterios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('elemento_id'); // Clave foránea hacia elementos
            $table->string('nombre'); // Nombre del criterio
            $table->foreign('elemento_id')->references('id')->on('elementos')->onDelete('cascade'); // Clave foránea
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('criterios');
    }
}
