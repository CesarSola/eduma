<?php


namespace App\Http\Controllers;

use App\Models\ComprobantePago;
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
        $comprobanteExistente = ComprobantePago::where('user_id', $user->id)
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
        $selectedCursoId = $request->input('curso_id');

        if (!$selectedCursoId) {
            return redirect()->back()->with('error', 'ID de curso no válido');
        }

        // Obtener el curso seleccionado
        $curso = Curso::findOrFail($selectedCursoId);

        // Nombre del usuario y del curso para el almacenamiento del archivo
        $userName = str_replace(' ', '_', $user->name);
        $cursoName = str_replace(' ', '_', $curso->name);

        // Validar y guardar el comprobante de pago
        if ($request->hasFile('comprobante_pago')) {
            $comprobantePago = $request->file('comprobante_pago');
            $comprobantePagoName = 'Comprobante_Pago_' . $cursoName . '.' . $comprobantePago->extension();
            $comprobantePagoPath = $comprobantePago->storeAs('public/documents/records/payments/' . $userName, $comprobantePagoName);

            // Crear y guardar el registro del comprobante de pago
            $comprobante = new ComprobantePago();
            $comprobante->user_id = $user->id;
            $comprobante->curso_id = $selectedCursoId;
            $comprobante->comprobante_pago = $comprobantePagoPath;

            // Asignar el tipo como 'curso' al guardar el comprobante
            $comprobante->tipo = 'curso';

            $comprobante->save();

            // Guardar la relación en la tabla pivot (si es necesario)
            // $user->cursos()->syncWithoutDetaching([$selectedCursoId]);

            return redirect()->route('registroCurso.show', ['cursoId' => $selectedCursoId])->with('success', 'Comprobante de pago subido correctamente');
        } else {
            return redirect()->back()->with('error', 'No se seleccionó ningún archivo para subir');
        }
    }
}
