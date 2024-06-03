<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\CodigoPostal;

class CodigosPostalesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new CodigoPostal([
            'd_codigo' => $row[0], // Código Postal
            'd_asenta' => $row[1], // Asentamiento
            'd_tipo_asenta' => $row[2], // Tipo Asentamiento
            'D_mnpio' => $row[3], // Delegación/Municipio
            'd_estado' => $row[4], // Estado
            'd_ciudad' => $row[5], // Ciudad
            'd_CP' => $row[6], // Código Postal (segunda ocurrencia)
            'c_estado' => $row[7], // Código Estado
            'c_oficina' => $row[8], // Código Oficina
            'c_tipo_asenta' => $row[9], // Código Tipo Asentamiento
            'c_mnpio' => $row[10], // Código Municipio
            'id_asenta_cpcons' => $row[11], // ID Asentamiento CP Consulta
            'd_zona' => $row[12], // Zona
            'c_cve_ciudad' => $row[13], // Código Clave Ciudad
            // Agrega aquí más campos si es necesario
        ]);
    }
}
