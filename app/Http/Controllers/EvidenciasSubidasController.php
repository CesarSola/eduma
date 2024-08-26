<?php

namespace App\Http\Controllers;

use App\Models\DocumentosEvidencias;
use App\Models\Estandares;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EvidenciasSubidasController extends Controller
{
    public function index($id, $name)
    {
        // Suponemos que $id es el ID del estándar y $name es el nombre del estándar.
        $estandarId = $id;
        $estandarName = $name;

        // Obtén todos los documentos asociados al estándar dado y al usuario autenticado
        $userId = Auth::id();  // Usar el ID del usuario autenticado

        $documentos = DocumentosEvidencias::where('estandar_id', $estandarId)
            ->where('user_id', $userId)  // Filtra por usuario
            ->get();

        // Obtén el nombre del usuario
        $usuario = User::find($userId);
        $usuarioName = $usuario ? $usuario->name : 'Desconocido';

        // Modifica la vista para incluir los datos necesarios para el modal
        return view('expedientes.expedientesUser.evidenciasEC.evidenciasSubidas.index', [
            'documentos' => $documentos,
            'estandarId' => $estandarId,
            'estandarName' => $estandarName,
            'usuarioId' => $userId,
            'usuarioName' => $usuarioName
        ]);
    }
}
