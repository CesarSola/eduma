<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\CodigoPostal;
use Illuminate\Support\Facades\Log;

class CodigosPostalesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Verificar que los campos críticos no sean nulos
        if (
            !is_null($row['d_codigo']) && !is_null($row['d_asenta']) && !is_null($row['d_tipo_asenta']) &&
            !is_null($row['d_mnpio']) && !is_null($row['d_estado']) && !is_null($row['d_ciudad']) &&
            !is_null($row['d_cp']) && !is_null($row['c_estado']) && !is_null($row['c_oficina']) &&
            !is_null($row['c_tipo_asenta']) && !is_null($row['c_mnpio']) && !is_null($row['id_asenta_cpcons']) &&
            !is_null($row['d_zona']) && !is_null($row['c_cve_ciudad'])
        ) {
            return new CodigoPostal([
                'd_codigo' => $row['d_codigo'], // Código Postal
                'd_asenta' => $row['d_asenta'], // Asentamiento
                'd_tipo_asenta' => $row['d_tipo_asenta'], // Tipo Asentamiento
                'D_mnpio' => $row['d_mnpio'], // Delegación/Municipio
                'd_estado' => $row['d_estado'], // Estado
                'd_ciudad' => $row['d_ciudad'], // Ciudad
                'd_CP' => $row['d_cp'], // Código Postal (segunda ocurrencia)
                'c_estado' => $row['c_estado'], // Código Estado
                'c_oficina' => $row['c_oficina'], // Código Oficina
                'c_tipo_asenta' => $row['c_tipo_asenta'], // Código Tipo Asentamiento
                'c_mnpio' => $row['c_mnpio'], // Código Municipio
                'id_asenta_cpcons' => $row['id_asenta_cpcons'], // ID Asentamiento CP Consulta
                'd_zona' => $row['d_zona'], // Zona
                'c_cve_ciudad' => $row['c_cve_ciudad'], // Código Clave Ciudad
            ]);
        } else {
            // Registrar un log para las filas incompletas o con valores nulos en campos obligatorios
            Log::warning('Fila incompleta o con valores nulos encontrada', ['row' => $row]);
            return null;
        }
    }
}
