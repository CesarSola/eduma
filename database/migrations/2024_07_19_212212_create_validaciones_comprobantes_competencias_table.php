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
        Schema::create('validaciones_comprobantes_competencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comprobante_id');
            $table->unsignedBigInteger('user_id');
            $table->string('tipo_documento');
            $table->enum('tipo_validacion', ['validar', 'rechazar', 'pendiente'])->default('pendiente');
            $table->text('comentario')->nullable();
            $table->timestamps();
            $table->foreign('comprobante_id')->references('id')->on('comprobantes_competencias')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('validaciones_comprobantes_competencias');
    }
};
