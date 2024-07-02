<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('validaciones_comentarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('documento_user_id')->nullable();
            $table->unsignedBigInteger('comprobanteCO_id')->nullable();
            $table->unsignedBigInteger('comprobanteCU_id')->nullable(); // Agregamos esta columna
            $table->string('tipo_documento'); // Tipo de documento (foto, INE/IFE, etc.)
            $table->enum('tipo_validacion', ['validar', 'rechazar', 'pendiente'])->default('pendiente');
            $table->text('comentario')->nullable();
            $table->timestamps();

            // Definir las claves foráneas
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('documento_user_id')->references('id')->on('documentos_user')->onDelete('cascade');
            $table->foreign('comprobanteCO_id')->references('id')->on('comprobantes_competencias')->onDelete('cascade');
            $table->foreign('comprobanteCU_id')->references('id')->on('comprobantes_cursos')->onDelete('cascade'); // Clave foránea para comprobantes_cursos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validaciones_comentarios');
    }
};
