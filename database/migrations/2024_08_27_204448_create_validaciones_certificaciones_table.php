<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValidacionesCertificacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('validaciones_certificaciones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comprobante_id');
            $table->unsignedBigInteger('user_id');
            $table->string('tipo_documento');
            $table->enum('tipo_validacion', ['validar', 'rechazar', 'pendiente'])->default('pendiente');
            $table->text('comentario')->nullable();
            $table->timestamps();

            // Claves foráneas
            $table->foreign('comprobante_id')->references('id')->on('comprobante_certificacion')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('validaciones_certificaciones');
    }
}
