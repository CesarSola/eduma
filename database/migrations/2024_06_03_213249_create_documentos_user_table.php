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
        Schema::create('documentos_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Para relacionar con el usuario
            $table->string('foto'); // Ruta de la foto
            $table->string('ine_ife'); // Ruta de la identificación
            $table->string('comprobante_domiciliario'); // Ruta del comprobante domiciliario
            $table->string('curp'); // Ruta del CURP
            $table->string('comprobante_pago'); // Ruta del comprobante de pago
            $table->string('ficha_inscripcion'); // Ruta de la ficha de inscripción
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos_user');
    }
};
