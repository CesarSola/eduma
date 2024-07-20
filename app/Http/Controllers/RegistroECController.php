<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ComprobantesCO;
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
        $comprobanteExistente = ComprobantesCO::where('user_id', $user->id)
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
        $userSecondName = str_replace(' ', '_', $user->secondName);
        $userPaternalSurname = str_replace(' ', '_', $user->paternalSurname);
        $userMaternalSurname = str_replace(' ', '_', $user->maternalSurname);
        $userMatricula = str_replace(' ', '_', $user->matricula);
        $estandarName = str_replace(' ', '_', $estandar->name);
        // Obtener el usuario con sus relaciones cargadas
        $user = User::with('estandares')->findOrFail($user->id); // Asegúrate de que 'estandares' coincida con el nombre de la relación definida en el modelo User

        // Validar y guardar el comprobante de pago
        if ($request->hasFile('comprobante_pago')) {
            $comprobante = $request->file('comprobante_pago');
            $comprobantePagoName = 'Comprobante_Pago_' . $estandarName . '.' . $comprobante->extension();
            $comprobantePagoPath = $comprobante->storeAs(
                'public/documents/records/payments/competences/standards/' .
                    $userMatricula . '/' .
                    $userName . ' ' .
                    $userSecondName . ' ' .
                    $userPaternalSurname . ' ' .
                    $userMaternalSurname,
                $comprobantePagoName
            );

            // Crear y guardar el registro del comprobante de pago
            $comprobanteCompetencia = new ComprobantesCO();
            $comprobanteCompetencia->user_id = $user->id;
            $comprobanteCompetencia->estandar_id = $selectedECId;
            $comprobanteCompetencia->comprobante_pago = $comprobantePagoPath;
            // Puedes ajustar el estado inicial según sea necesario

            $comprobanteCompetencia->save();
            // Guardar la relación en la tabla pivot
            $user->estandares()->syncWithoutDetaching([$selectedECId]);

            return redirect()->route('competenciaEC.show', ['competenciaEC' => $selectedECId])->with('success', 'Comprobante de pago subido correctamente');
        } else {
            return redirect()->back()->with('error', 'No se seleccionó ningún archivo para subir');
        }
    }
}
