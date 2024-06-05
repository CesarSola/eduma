<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentosUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documentos_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Para relacionar con el usuario
            $table->string('foto')->nullable(); // Ruta de la foto, ahora nullable
            $table->string('ine_ife')->nullable(); // Ruta de la identificación
            $table->string('comprobante_domiciliario')->nullable(); // Ruta del comprobante domiciliario
            $table->string('curp')->nullable(); // Ruta del CURP
            $table->string('comprobante_pago')->nullable(); // Ruta del comprobante de pago
            $table->string('ficha_inscripcion')->nullable(); // Ruta de la ficha de inscripción
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
}
