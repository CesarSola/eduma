<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichasDocumentosTable extends Migration
{
    public function up()
    {
        Schema::create('fichas_documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('estandar_id')->constrained('estandares')->onDelete('cascade');
            $table->string('nombre');
            $table->string('file_path'); // Guardará la ruta al archivo en el storage
            $table->json('estado')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fichas_documentos');
    }
}
