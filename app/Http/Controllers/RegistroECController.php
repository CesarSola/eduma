<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ComprobantePago;
use App\Models\Estandares;
use App\Models\User;

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
        $selectedECId = $request->input('competencia_id');

        if (!$selectedECId) {
            return redirect()->back()->with('error', 'ID de competencia no válido');
        }

        // Obtener la competencia seleccionada
        $estandar = Estandares::findOrFail($selectedECId);

        // Nombre del usuario y de la competencia para el almacenamiento del archivo
        $userName = str_replace(' ', '_', $user->name);
        $estandarName = str_replace(' ', '_', $estandar->name);

        // Validar y guardar el comprobante de pago
        if ($request->hasFile('comprobante_pago')) {
            $comprobantePago = $request->file('comprobante_pago');
            $comprobantePagoName = 'Comprobante_Pago_' . $estandarName . '.' . $comprobantePago->extension();
            $comprobantePagoPath = $comprobantePago->storeAs('public/documents/records/payments/' . $userName, $comprobantePagoName);

            // Crear y guardar el registro del comprobante de pago
            $comprobante = new ComprobantePago();
            $comprobante->user_id = $user->id;
            $comprobante->estandar_id = $selectedECId;
            $comprobante->comprobante_pago = $comprobantePagoPath;

            // Asignar el tipo como 'competencia' al guardar el comprobante
            $comprobante->tipo = 'competencia';

            $comprobante->save();

            // Guardar la relación en la tabla pivot (si es necesario)
            // $user->estandares()->syncWithoutDetaching([$selectedECId]);

            return redirect()->route('competenciaEC.show', ['competenciaEC' => $selectedECId])->with('success', 'Comprobante de pago subido correctamente');
        } else {
            return redirect()->back()->with('error', 'No se seleccionó ningún archivo para subir');
        }
    }
}
