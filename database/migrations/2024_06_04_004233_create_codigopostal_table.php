<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCodigopostalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigopostal', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID como BIGINT
            $table->string('d_codigo'); // Código postal
            $table->string('d_asenta'); // Asentamiento
            $table->string('d_tipo_asenta'); // Tipo de asentamiento
            $table->string('D_mnpio'); // Municipio
            $table->string('d_estado'); // Estado
            $table->string('d_ciudad'); // Ciudad
            $table->string('d_CP'); // Código postal
            $table->string('c_estado'); // Código de estado
            $table->string('c_oficina'); // Oficina
            $table->string('c_tipo_asenta'); // Código tipo asentamiento
            $table->string('c_mnpio'); // Código municipio
            $table->string('id_asenta_cpcons'); // ID asentamiento cpcons
            $table->string('d_zona'); // Zona
            $table->string('c_cve_ciudad'); // Clave ciudad
            $table->timestamps(); // Columnas created_at y updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codigopostal');
    }
}
