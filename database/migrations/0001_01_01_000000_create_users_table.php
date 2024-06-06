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
            $table->string('genero')->nullable();  //campo edad
            $table->string('email')->unique(); // campo email/correo
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password'); // campo contraseña
            $table->string('calle_avenida')->nullable(); // Campo calle/avenida
            $table->string('numext')->nullable(); // Campo numext
            $table->string('codpos')->nullable(); // Campo codpos
            $table->string('colonia')->nullable(); // Campo colonia
            $table->string('estado')->nullable(); // Campo estado
            $table->string('ciudad')->nullable(); // Campo ciudad
            $table->string('municipio')->nullable(); // Campo municipio
            $table->string('phone')->nullable(); // Campo municipio
            $table->rememberToken();
            $table->timestamps();
        });


        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
