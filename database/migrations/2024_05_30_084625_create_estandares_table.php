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
        Schema::create('estandares', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('numero');
            $table->string('name');
            $table->string('Dnecesarios', 999);
            $table->string('tipo');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('documentosnec_id')
            ->nullable()
            ->constrained('documentosnec')
            ->cascadeOnUpdate()
            ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estandares');
    }
};
