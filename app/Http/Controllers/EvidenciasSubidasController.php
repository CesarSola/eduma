<?php

namespace App\Http\Controllers;

use App\Models\DocumentosEvidencias;
use App\Models\Estandares;

class EvidenciasSubidasController extends Controller
{
    public function index($estandarId)
    {
        // Obtén todos los documentos asociados al estándar dado
        $documentos = DocumentosEvidencias::where('estandar_id', $estandarId)
            ->get();

        // Obtén el nombre del estándar
        $estandar = Estandares::find($estandarId);
        $estandarName = $estandar ? $estandar->name : 'Desconocido';

        return view('expedientes.expedientesUser.evidenciasEC.evidenciasSubidas.index', [
            'documentos' => $documentos,
            'estandarId' => $estandarId,
            'estandarName' => $estandarName
        ]);
    }
}
