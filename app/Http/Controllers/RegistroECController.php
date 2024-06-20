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
    public function index()
    {
        $competencias = Estandares::all(); // Obtén todas las competencias disponibles
        return view('expedientes.expedientesUser.registroEC.index', compact('competencias'));
    }

    /**
     * Show the form for uploading a payment receipt.
     */
    public function show($competenciaEC)
    {
        $competencia = Estandares::findOrFail($competenciaEC);
        $user = Auth::user();
        $comprobanteExistente = ComprobantePago::where('user_id', $user->id)
            ->where('estandar_id', $competenciaEC)
            ->first();

        return view('expedientes.expedientesUser.registroEC.show', compact('competencia', 'comprobanteExistente'));
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

            return redirect()->route('competenciaEC.show', ['competenciaEC' => $selectedECId])->with('success', 'Comprobante de pago subido correctamente');
        } else {
            return redirect()->back()->with('error', 'No se seleccionó ningún archivo para subir');
        }
    }
}
