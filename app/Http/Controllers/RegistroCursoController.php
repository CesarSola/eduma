<?php


namespace App\Http\Controllers;

use App\Models\ComprobantePago;
use App\Models\ComprobantesCU;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;
use App\Models\User;

class RegistroCursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Curso::all(); // Obtén todos los cursos disponibles
        return view('expedientes.expedientesUser.registroCurso.index', compact('cursos'));
    }

    /**
     * Show the form for uploading a payment receipt.
     */
    public function show($cursoId)
    {
        $curso = Curso::findOrFail($cursoId);
        $user = Auth::user();
        $comprobanteExistente = ComprobantesCU::where('user_id', $user->id)
            ->where('curso_id', $cursoId)
            ->first();

        return view('expedientes.expedientesUser.registroCurso.show', compact('curso', 'comprobanteExistente'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $selectedECId = $request->input('curso_id');

        if (!$selectedECId) {
            return redirect()->back()->with('error', 'ID de curso no válido');
        }

        // Obtener el curso seleccionado
        $curso = Curso::findOrFail($selectedECId);

        // Nombre del usuario y del curso para el almacenamiento del archivo
        $userName = str_replace(' ', '_', $user->name);
        $cursoName = str_replace(' ', '_', $curso->name);
        $user = User::with('cursos')->findOrFail($user->id); // Asegúrate de que 'cursos' coincida con el nombre de la relación definida en el modelo User
        // Validar y guardar el comprobante de pago
        if ($request->hasFile('comprobante_pago')) {
            $comprobanteCU = $request->file('comprobante_pago');
            $comprobantePagoName = 'Comprobante_Pago_' . $cursoName . '.' . $comprobanteCU->extension();
            $comprobantePagoPath = $comprobanteCU->storeAs('public/documents/records/payments/courses/' . $userName, $comprobantePagoName);

            // Crear y guardar el registro del comprobante de pago
            $comprobanteCurso = new ComprobantesCU();
            $comprobanteCurso->user_id = $user->id;
            $comprobanteCurso->curso_id = $selectedECId;
            $comprobanteCurso->comprobante_pago = $comprobantePagoPath;

            $comprobanteCurso->save();

            // Guardar la relación en la tabla pivot (si es necesario)
            $user->cursos()->syncWithoutDetaching([$selectedECId]);

            return redirect()->route('registroCurso.show', ['registroCurso' => $selectedECId])->with('success', 'Comprobante de pago subido correctamente');
        } else {
            return redirect()->back()->with('error', 'No se seleccionó ningún archivo para subir');
        }
    }
}
