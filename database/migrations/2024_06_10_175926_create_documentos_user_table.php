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
            $table->string('foto'); // Ruta de la foto
            $table->string('ine_ife'); // Ruta de la identificación
            $table->string('comprobante_domiciliario'); // Ruta del comprobante domiciliario
            $table->string('curp'); // Ruta del CURP
            $table->json('estado')->nullable(); // Estado como JSON
            $table->timestamps();

            // Eliminar temporalmente la restricción de clave foránea
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la tabla sin preocuparse por la restricción de clave foránea aquí
        Schema::dropIfExists('documentos_user');
    }
}
