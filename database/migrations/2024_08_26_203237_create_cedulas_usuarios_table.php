<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCedulasUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cedulas_usuarios', function (Blueprint $table) {
            $table->id(); // ID auto-incremental
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // Llave foránea hacia la tabla 'users'
            $table->string('nombre_usuario'); // Nombre completo del usuario
            $table->foreignId('estandar_id')->constrained('estandares')->onDelete('cascade'); // Llave foránea hacia la tabla 'estandares'
            $table->string('nombre'); // Nombre del documento
            $table->string('file_path'); // Ruta del archivo
            $table->timestamps(); // Timestamps para 'created_at' y 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cedulas_usuarios');
    }
}
