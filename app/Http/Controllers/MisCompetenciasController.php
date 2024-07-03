<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\User;
use App\Models\ValidacionesComentarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class MisCompetenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usuario = User::findOrFail(auth()->user()->id);
        $competencias = $usuario->estandares()->with('comprobantesCO')->get();

        return view('expedientes.expedientesUser.competencias.index', compact('competencias', 'usuario'));
    }
    /**
     * Mostrar la vista para re-subir el comprobante de pago rechazado.
     */
    public function mostrarRechazado($id)
    {
        $competencia = Estandares::findOrFail($id);
        $validacionComentario = ValidacionesComentarios::where('estandar_id', $competencia->id)
            ->where('tipo_documento', 'comprobante_pago')
            ->first();

        // Si no hay validación de comprobante, podemos manejarlo como necesario
        return view('expedientes.expedientesUser.competencias.resubir_comprobante', compact('competencia', 'validacionComentario'));
    }
    // Método para guardar la re-subida del comprobante de pago
    public function guardarResubirComprobante(Request $request, $id)
    {
        $competencia = Estandares::findOrFail($id);
        $comprobantePago = $competencia->comprobantePago;

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
            $fileName = 'Comprobante_Pago_' . $competencia->name . '.' . $nuevoComprobante->getClientOriginalExtension();
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
            $validacionComentario = ValidacionesComentarios::where('comprobanteCO_id', $comprobantePago->id)->first();

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
                    'comprobanteCO_id' => $comprobantePago->id,
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
     * Mostrar la vista para re-subir el comprobante de pago rechazado.
     */
}
