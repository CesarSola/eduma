<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtencionUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atencion_usuarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('estandar_id')->constrained('estandares')->onDelete('cascade');
            $table->string('año');
            $table->string('presencial');
            $table->string('celular');
            $table->string('correo');
            $table->string('otro_medio')->nullable();
            $table->string('lugar');
            $table->date('fecha');
            $table->string('nombre');
            $table->string('apellidos');
            $table->string('domicilio');
            $table->string('colonia');
            $table->string('codigo_postal');
            $table->string('delegacion');
            $table->string('estado');
            $table->string('ciudad');
            $table->string('fax')->nullable();
            $table->string('telefono');
            $table->string('email');
            $table->string('calificacion_atencion');
            $table->string('tiempo_atencion');
            $table->string('trato_amable');
            $table->string('confianza_atencion');
            $table->string('comprension_atencion');
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
        Schema::dropIfExists('atencion_usuarios');
    }
}
