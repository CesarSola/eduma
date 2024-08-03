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
        Schema::create('diagnosticos', function (Blueprint $table) {
            $table->id(); // Crea una columna 'id' auto incremental como clave primaria
            $table->string('codigo'); // Columna 'codigo'
            $table->string('nombre'); // Columna 'nombre'
            $table->text('descripcion')->nullable(); // Columna 'descripcion', permitiendo valores nulos
            $table->timestamps(); // Crea las columnas 'created_at' y 'updated_at'
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnosticos');
    }
};
