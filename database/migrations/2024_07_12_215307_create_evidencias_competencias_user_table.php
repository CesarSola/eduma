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
        Schema::create('evidencias_competencias_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('evidencias_competencias_id');
            $table->unsignedBigInteger('user_id');
            // Otros campos si son necesarios
            $table->timestamps();

            $table->foreign('evidencias_competencias_id')->references('id')->on('evidencias_competencias')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencias_competencias_user');
    }
};
