<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ComprobantePago;
use App\Models\Estandares;

class RegistroECController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $selectedECId = $request->query('id');
        $estandar_id = Estandares::findOrFail($selectedECId);

        // Verifica si ya existe un comprobante de pago para el usuario y el estándar actual
        $user = Auth::user();
        $comprobanteExistente = ComprobantePago::where('user_id', $user->id)
            ->where('estandar_id', $selectedECId)
            ->first();

        return view('expedientes.expedientesUser.registroEC.index', compact('estandar_id', 'selectedECId', 'comprobanteExistente'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $userName = str_replace(' ', '_', $user->name);
        $selectedECId = $request->input('competencia_id');

        if (!$selectedECId) {
            return redirect()->back()->with('error', 'ID de competencia no válido');
        }

        $estandar = Estandares::findOrFail($selectedECId);
        $estandarName = str_replace(' ', '_', $estandar->name);

        if ($request->hasFile('comprobante_pago')) {
            $comprobantePago = $request->file('comprobante_pago');
            $comprobantePagoName = 'Comprobante_Pago_' . $estandarName . '.' . $comprobantePago->extension();
            $comprobantePagoPath = $comprobantePago->storeAs('public/images/documentos/' . $userName, $comprobantePagoName);

            // Guardar la ruta del comprobante de pago en la base de datos
            $comprobante = new ComprobantePago();
            $comprobante->user_id = $user->id;
            $comprobante->estandar_id = $selectedECId;
            $comprobante->comprobante_pago = $comprobantePagoPath;

            $comprobante->save();

            return redirect()->route('competenciaEC.index', ['id' => $selectedECId])->with('success', 'Comprobante de pago subido correctamente');
        } else {
            return redirect()->back()->with('error', 'No se seleccionó ningún archivo para subir');
        }
    }
}
