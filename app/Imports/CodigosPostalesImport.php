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
        // Normalizamos los nombres de los encabezados a minúsculas
        $row = array_change_key_case($row, CASE_LOWER);

        Log::info('Fila importada:', $row); // Registro de toda la fila importada

        if (isset($row['d_codigo']) && isset($row['c_tipo_asenta']) && isset($row['d_mnpio'])) {
            return new CodigoPostal([
                'd_codigo' => $row['d_codigo'], // Código Postal
                'd_asenta' => $row['d_asenta'], // Asentamiento
                'd_tipo_asenta' => $row['d_tipo_asenta'], // Tipo Asentamiento
                'D_mnpio' => $row['d_mnpio'], // Delegación/Municipio
                'd_estado' => $row['d_estado'], // Estado
                'd_ciudad' => $row['d_ciudad'], // Ciudad
                'd_cp' => $row['d_cp'], // Código Postal (segunda ocurrencia)
                'c_estado' => $row['c_estado'], // Código Estado
                'c_oficina' => $row['c_oficina'], // Código Oficina
                'c_tipo_asenta' => $row['c_tipo_asenta'], // Código Tipo Asentamiento
                'c_mnpio' => $row['c_mnpio'], // Código Municipio
                'id_asenta_cpcons' => $row['id_asenta_cpcons'], // ID Asentamiento CP Consulta
                'd_zona' => $row['d_zona'], // Zona
                'c_cve_ciudad' => $row['c_cve_ciudad'], // Código Clave Ciudad
            ]);
        }

        Log::error('Fila inválida: ', $row); // Registro de la fila inválida
        return null;
    }
}