<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ComprobanteCertificacion;
use App\Models\Estandares;
use App\Models\EvaluadoresUsuarios;
use App\Models\User;

class ComprobanteCertificacionController extends Controller
{
    /**
     * Show the form for uploading a payment receipt.
     */
    public function show($id, $competenciaEC = null)
    {
        $competencia = Estandares::findOrFail($competenciaEC ?? $id); // Usar $id si $competenciaEC es nulo
        $user = Auth::user();
        $user_id = Auth::id();

        $evaluador = EvaluadoresUsuarios::where('usuario_id', $user_id)
            ->where('estandar_id', $id)
            ->with('evaluador')
            ->first();

        $comprobanteExistente = ComprobanteCertificacion::where('user_id', $user->id)
            ->where('estandar_id', $competenciaEC ?? $id)
            ->first();

        return view('expedientes.expedientesUser.evidenciasEC.comprobanteCertificacion.show', compact('competencia', 'comprobanteExistente', 'evaluador'));
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
        $userSecondName = str_replace(' ', '_', $user->secondName);
        $userPaternalSurname = str_replace(' ', '_', $user->paternalSurname);
        $userMaternalSurname = str_replace(' ', '_', $user->maternalSurname);
        $userMatricula = str_replace(' ', '_', $user->matricula);
        $estandarName = str_replace(' ', '_', $estandar->name);

        // Validar y guardar el comprobante de pago
        if ($request->hasFile('comprobante_pago')) {
            $comprobante = $request->file('comprobante_pago');
            $comprobantePagoName = 'Comprobante_Pago_Certificacion_' . $estandarName . '.' . $comprobante->extension();
            $comprobantePagoPath = $comprobante->storeAs(
                'public/documents/records/payments/competences/standards/' .
                    $userMatricula . '/' .
                    $userName . '_' .
                    $userSecondName . '_' .
                    $userPaternalSurname . '_' .
                    $userMaternalSurname . '/' .
                    $estandarName . '/' .
                    '/certificados_pago' . '/' .
                    $comprobantePagoName
            );

            // Crear y guardar el registro del comprobante de pago
            $comprobanteCertificacion = new ComprobanteCertificacion();
            $comprobanteCertificacion->user_id = $user->id;
            $comprobanteCertificacion->estandar_id = $selectedECId;
            $comprobanteCertificacion->comprobante_pago = $comprobantePagoPath;

            $comprobanteCertificacion->save();

            // Redireccionar a la vista de evidencias con los parámetros necesarios
            return redirect()->route('evidenciasEC.index', ['id' => $selectedECId, 'name' => $estandarName])->with('success', 'Comprobante de pago subido correctamente');
        } else {
            return redirect()->back()->with('error', 'No se seleccionó ningún archivo para subir');
        }
    }
}
