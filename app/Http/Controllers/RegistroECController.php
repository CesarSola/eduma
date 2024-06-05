<?php

namespace App\Http\Controllers;

use App\Models\DocumentosUser;
use App\Models\Estandares;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegistroECController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtener el ID del EC seleccionado
        $selectedECId = $request->query('id');

        // Obtener el EC seleccionado
        $competencia = Estandares::findOrFail($selectedECId);

        // Pasar los datos a la vista
        return view('expedientes.expedientesUser.registroEC.index', compact('competencia'));
    }

    /**
     * Display the Inscription Documents view.
     */
    public function documentosIns()
    {
        // Puedes ajustar esta lógica según sea necesario para mostrar la vista de documentos de inscripción
        return view('expedientes.expedientesUser.registroEC.documentosIns');
    }

    /**
     * Display the Payment Documents view.
     */
    public function documentosComp()
    {
        // Puedes ajustar esta lógica según sea necesario para mostrar la vista de documentos de comprobación
        return view('expedientes.expedientesUser.registroEC.documentosComp');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $userName = str_replace(' ', '_', $user->name); // Reemplaza espacios en blanco con guiones bajos

        // Obtener el ID del EC seleccionado
        $selectedECId = $request->query('id');

        // Verificar si el ID de la competencia está presente
        if (!$selectedECId) {
            return redirect()->back()->with('error', 'ID de competencia no válido');
        }

        // Validar y almacenar la ficha de inscripción
        if ($request->hasFile('ficha_inscripcion')) {
            $fichaInscripcion = $request->file('ficha_inscripcion');
            $fichaInscripcionPath = $fichaInscripcion->storeAs('public/images/documentos/' . $userName, 'Ficha_Inscripcion.' . $fichaInscripcion->extension());
        }

        // Validar y almacenar el comprobante de pago
        if ($request->hasFile('comprobante_pago')) {
            $comprobantePago = $request->file('comprobante_pago');
            $comprobantePagoPath = $comprobantePago->storeAs('public/images/documentos/' . $userName, 'Comprobante_Pago.' . $comprobantePago->extension());
        }

        // Crear una nueva instancia del modelo para guardar en la base de datos
        $documento = new DocumentosUser();
        $documento->user_id = $user->id;
        $documento->ficha_inscripcion = $fichaInscripcionPath ?? null;
        $documento->comprobante_pago = $comprobantePagoPath ?? null;
        // Asigna otras propiedades del modelo si es necesario
        $documento->save();

        // Redireccionar a la página index o donde desees
        return redirect()->route('competenciaEC.index', ['id' => $selectedECId])->with('success', 'Documentos subidos correctamente');
    }
}
