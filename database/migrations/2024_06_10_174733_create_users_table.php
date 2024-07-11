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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name'); //campo nombre
            $table->string('secondName')->nullable();  //campo segundo nombre
            $table->string('paternalSurname')->nullable();  //campo apellido paterno
            $table->string('maternalSurname')->nullable();  //campo apellido materno
            $table->string('age')->nullable();  //campo edad
            $table->string('genero')->nullable();  //campo genero
            $table->string('matricula')->unique();
            $table->string('curp')->nullable(); // Cambiado a string para almacenar CURP
            $table->string('nacionalidad')->nullable(); // Cambiado a string para almacenar nacionalidad
            $table->date('nacimiento')->nullable();
            $table->string('password'); // campo contraseña
            $table->string('calle_avenida')->nullable(); // Campo calle/avenida
            $table->string('numext')->nullable(); // Campo numext
            $table->string('d_asenta')->nullable(); // Campo colonia
            $table->string('d_estado')->nullable(); // Campo estado
            $table->string('d_ciudad')->nullable(); // Campo ciudad
            $table->string('D_mnpio')->nullable(); // Campo municipio
            $table->string('d_codigo')->nullable(); // Campo codpos
            $table->string('foto')->nullable(); // Campo foto
            $table->string('phone')->nullable(); // Campo telefono
            $table->string('email')->unique(); // campo email/correo
            $table->timestamp('email_verified_at')->nullable();
            $table->string('google_id')->nullable(); //campo id de google

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
