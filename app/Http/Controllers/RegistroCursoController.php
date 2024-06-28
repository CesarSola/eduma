<?php


namespace App\Http\Controllers;

use App\Models\ComprobantePago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Curso;
use App\Models\ComprobantePagoCurso;
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
        $userName = str_replace(' ', '_', $user->name);
        $selectedCursoId = $request->input('curso_id');

        if (!$selectedCursoId) {
            return redirect()->back()->with('error', 'ID de curso no válido');
        }

        // Obtener el usuario con sus relaciones cargadas
        $user = User::with('cursos')->findOrFail($user->id); // Asegúrate de que 'cursos' coincida con el nombre de la relación definida en el modelo User

        $curso = Curso::findOrFail($selectedCursoId);
        $cursoName = str_replace(' ', '_', $curso->name);

        if ($request->hasFile('comprobante_pago')) {
            $comprobantePago = $request->file('comprobante_pago');
            $comprobantePagoName = 'Comprobante_Pago_' . $cursoName . '.' . $comprobantePago->extension();
            $comprobantePagoPath = $comprobantePago->storeAs('public/documents/records/payments/' . $userName, $comprobantePagoName);

            // Guardar la ruta del comprobante de pago en la base de datos
            $comprobante = new ComprobantePagoCurso();
            $comprobante->user_id = $user->id;
            $comprobante->curso_id = $selectedCursoId;
            $comprobante->comprobante_pago = $comprobantePagoPath;

            $comprobante->save();

            // Guardar la relación en la tabla pivot
            $user->cursos()->syncWithoutDetaching([$selectedCursoId]);

            return redirect()->route('curso.show', ['cursoId' => $selectedCursoId])->with('success', 'Comprobante de pago subido correctamente');
        } else {
            return redirect()->back()->with('error', 'No se seleccionó ningún archivo para subir');
        }
    }
}
