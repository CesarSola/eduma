<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompetenciaDocumentosnecTable extends Migration
{
    public function up()
    {
        Schema::create('competencia_documentosnec', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competencia_id')->constrained('estandares')->onDelete('cascade');
            $table->foreignId('documentosnec_id')->constrained('documentosnec')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('competencia_documentosnec');
    }
}
