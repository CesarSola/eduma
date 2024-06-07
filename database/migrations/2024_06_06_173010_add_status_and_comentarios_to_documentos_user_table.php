<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndComentariosToDocumentosUserTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('documentos_user', function (Blueprint $table) {
            $table->string('status')->nullable();
            $table->text('comentarios')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('documentos_user', function (Blueprint $table) {
            $table->dropColumn(['status', 'comentarios']);
        });
    }
}
