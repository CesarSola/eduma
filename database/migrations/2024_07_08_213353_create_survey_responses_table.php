<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSurveyResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('survey_responses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('question1');
            $table->string('question2');
            $table->string('question3');
            $table->string('question4');
            $table->string('question5');
            $table->string('question6');
            $table->string('question7');
            $table->string('question8');
            $table->text('doubts')->nullable();
            $table->unsignedBigInteger('user_id'); // Añadir esta línea
            $table->unsignedBigInteger('estandar_id'); // Añadir esta línea
            $table->timestamps();
            
            // Opcional: si quieres definir claves foráneas
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('estandar_id')->references('id')->on('estandares')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('survey_responses');
    }
}
