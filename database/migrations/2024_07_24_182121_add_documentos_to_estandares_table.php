<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentosToEstandaresTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('estandares', function (Blueprint $table) {
            $table->json('documentos')->nullable(); // Agrega el campo 'documentos' como JSON
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('estandares', function (Blueprint $table) {
            $table->dropColumn('documentos'); // Elimina el campo 'documentos'
        });
    }
}
