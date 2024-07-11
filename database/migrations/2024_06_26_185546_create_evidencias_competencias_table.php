<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvidenciasCompetenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evidencias_competencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('estandar_id')->constrained('estandares')->onDelete('cascade');
            $table->foreignId('documento_id')->constrained('documentosnec')->onDelete('cascade');
            $table->string('file_path');
            $table->string('ficha_registro_path')->nullable(); // Campo para la ficha de registro
            $table->string('carta_firma_path')->nullable(); // Campo para la carta de la firma
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evidencias_competencias');
    }
}
