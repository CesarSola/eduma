<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFechasCompetenciasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('fechas_competencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('competencia_id');
            $table->foreign('competencia_id')->references('id')->on('estandares')->onDelete('cascade');
            $table->date('fecha');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('fechas_competencias');
    }
}
