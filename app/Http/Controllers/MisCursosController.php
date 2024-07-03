<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Curso; // Asegúrate de importar el modelo Curso aquí
use App\Models\ValidacionesComentarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MisCursosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = User::findOrFail(auth()->user()->id);
        $cursos = $usuario->cursos()->with('comprobantesCU')->get(); // Accede a la relación de cursos

        return view('expedientes.expedientesUser.miscursos.index', compact('cursos', 'usuario'));
    }
    /**
     * Mostrar la vista para re-subir el comprobante de pago rechazado.
     */
    public function mostrarRechazado($id)
    {
        $curso = Curso::findOrFail($id);
        $validacionComentario = ValidacionesComentarios::where('comprobanteCU_id', $curso->id)
            ->where('tipo_documento', 'comprobante_pago')
            ->first();

        // Si no hay validación de comprobante, podemos manejarlo como necesario
        return view('expedientes.expedientesUser.misCursos.resubir_comprobante', compact('curso', 'validacionComentario'));
    }
    // Método para guardar la re-subida del comprobante de pago
    public function guardarResubirComprobante(Request $request, $id)
    {
        $curso = Curso::findOrFail($id);
        $comprobantePago = $curso->comprobantePago;

        // Validar el formulario
        $request->validate([
            'nuevo_comprobante_pago' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        // Obtener el archivo del formulario
        $nuevoComprobante = $request->file('nuevo_comprobante_pago');

        try {
            // Obtener el nombre del usuario para la carpeta de almacenamiento
            $user = Auth::user();
            $userName = str_replace(' ', '_', $user->name);

            // Almacenar el archivo en la carpeta correspondiente con el nombre del estándar
            $fileName = 'Comprobante_Pago_' . $curso->name . '.' . $nuevoComprobante->getClientOriginalExtension();
            $filePath = $nuevoComprobante->storeAs('public/documents/records/users/' . $userName, $fileName);

            // Actualizar el comprobante de pago en la base de datos
            if ($comprobantePago) {
                // Eliminar el archivo anterior si existe
                if (!is_null($comprobantePago->path) && Storage::exists($comprobantePago->path)) {
                    Storage::delete($comprobantePago->path);
                }

                // Actualizar la información del comprobante de pago
                $comprobantePago->update([
                    'estado' => json_encode(['comprobante_pago' => 'en_validacion']),
                    'path' => $filePath,
                ]);
            }

            // Obtener el ID del usuario autenticado
            $user_id = Auth::id();

            // Buscar el registro existente en validaciones_comentarios
            $validacionComentario = ValidacionesComentarios::where('comprobanteCU_id', $comprobantePago->id)->first();

            if ($validacionComentario) {
                // Actualizar el registro existente
                $validacionComentario->update([
                    'tipo_documento' => 'comprobante_pago',
                    'tipo_validacion' => 'pendiente',
                    'user_id' => $user_id,
                ]);
            } else {
                // Crear un nuevo registro en validaciones_comentarios si no existe
                ValidacionesComentarios::create([
                    'comprobanteCU_id' => $comprobantePago->id,
                    'tipo_documento' => 'comprobante_pago',
                    'tipo_validacion' => 'pendiente',
                    'user_id' => $user_id,
                ]);
            }

            return redirect()->route('miscompetencias.index')->with('success', 'Comprobante de pago re-enviado correctamente.');
        } catch (\Exception $e) {
            // Captura cualquier excepción y muestra un mensaje de error
            return back()->withInput()->withErrors(['error' => 'Error al guardar el archivo: ' . $e->getMessage()]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        //
    }
}
