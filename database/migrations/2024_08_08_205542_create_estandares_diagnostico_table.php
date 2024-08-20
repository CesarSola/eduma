<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstandaresDiagnosticoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estandares_diagnostico', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estandar_id'); // Definición de la columna estandar_id como unsignedBigInteger
            $table->unsignedBigInteger('diagnostico_id'); // Definición de la columna diagnostico_id como unsignedBigInteger
            $table->timestamps();

            // Definición de las claves foráneas
            $table->foreign('estandar_id')
                ->references('id')
                ->on('estandares')
                ->onDelete('cascade');

            $table->foreign('diagnostico_id')
                ->references('id')
                ->on('diagnosticos')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estandares_diagnostico');
    }
}
