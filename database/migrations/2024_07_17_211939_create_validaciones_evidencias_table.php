<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidacionesEvidenciasTable extends Migration
{
    public function up()
    {
        Schema::create('validaciones_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('estandar_id')->constrained('estandares')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('documento_id')->nullable()->constrained('documentos_evidencias')->onDelete('cascade');
            $table->enum('tipo_validacion', ['validar', 'rechazar', 'pendiente'])->default('pendiente');
            $table->text('comentario')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('validaciones_evidencias');
    }
}
