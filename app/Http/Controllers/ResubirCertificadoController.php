<?php

namespace App\Http\Controllers;

use App\Models\ComprobanteCertificacion;
use App\Models\Estandares;
use App\Models\ValidacionesCertificaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ResubirCertificadoController extends Controller
{
    public function show($id)
    {
        // Obtener la competencia por ID
        $competencia = Estandares::findOrFail($id);

        // Buscar la validación del comprobante de esa competencia
        $validacionComentario = ValidacionesCertificaciones::whereHas('comprobanteCE', function ($query) use ($competencia) {
            $query->where('estandar_id', $competencia->id);
        })
            ->where('tipo_documento', 'comprobante')
            ->with('usuario') // Asegura cargar la relación usuario
            ->first();

        // Pasar los datos a la vista
        return view('expedientes.expedientesUser.evidenciasEC.comprobanteCertificacion.resubir.resubir_comprobante', compact('competencia', 'validacionComentario'));
    }
    public function getValidacion($id)
    {
        $userId = Auth::id(); // Obtener el ID del usuario actual

        $validacionComentario = ValidacionesCertificaciones::whereHas('comprobanteCE', function ($query) use ($id) {
            $query->where('estandar_id', $id);
        })
            ->where('tipo_documento', 'comprobante')
            ->where('user_id', $userId) // Asegúrate de que la validación es para el usuario actual
            ->with('usuario')
            ->first();

        if (!$validacionComentario) {
            return response()->json([
                'nombre_usuario' => 'No disponible',
                'tipo_validacion' => 'No disponible',
                'comentario' => 'No disponible'
            ]);
        }

        return response()->json([
            'nombre_usuario' => $validacionComentario->usuario->name ?? 'No disponible',
            'tipo_validacion' => $validacionComentario->tipo_validacion ?? 'No disponible',
            'comentario' => $validacionComentario->comentario ?? 'No disponible'
        ]);
    }

    public function guardarResubirComprobante(Request $request, $id)
    {
        $estandar = Estandares::findOrFail($id);

        // Busca el comprobante de pago para el estándar y el usuario actual
        $comprobantePago = $estandar->comprobantesCE()->where('user_id', Auth::id())->first();

        $request->validate([
            'nuevo_comprobante_pago' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $nuevoComprobante = $request->file('nuevo_comprobante_pago');

        try {
            $user = Auth::user();
            $userName = str_replace(' ', '_', $user->name);
            $userSecondName = str_replace(' ', '_', $user->secondName);
            $userPaternalSurname = str_replace(' ', '_', $user->paternalSurname);
            $userMaternalSurname = str_replace(' ', '_', $user->maternalSurname);
            $userMatricula = str_replace(' ', '_', $user->matricula);
            $estandarName = str_replace(' ', '_', $estandar->name);

            // Definir el nombre del archivo
            $fileName = 'Comprobante_Pago_Certificacion_' . $estandarName . '.' . $nuevoComprobante->getClientOriginalExtension();

            // Ruta de almacenamiento usando la misma estructura que store
            $folderPath = 'documents/records/payments/competences/standards/' .
                $userMatricula . '/' .
                $userName . '_' .
                $userSecondName . '_' .
                $userPaternalSurname . '_' .
                $userMaternalSurname . '/' .
                $estandarName . '/' .
                'certificados_pago';

            $filePath = $nuevoComprobante->storeAs($folderPath, $fileName, 'public');

            // Eliminar el archivo antiguo si existe
            if ($comprobantePago && !is_null($comprobantePago->comprobante_pago) && Storage::exists($comprobantePago->comprobante_pago)) {
                Storage::delete($comprobantePago->comprobante_pago);
                Log::info('Archivo antiguo eliminado: ' . $comprobantePago->comprobante_pago);
            }

            // Actualizar la base de datos
            if ($comprobantePago) {
                $comprobantePago->update([
                    'comprobante_pago' => $filePath,
                    'estado' => json_encode(['comprobante' => 'pendiente']),
                ]);
            } else {
                // Si no existe un comprobante, crear uno nuevo
                $comprobantePago = new ComprobanteCertificacion();
                $comprobantePago->user_id = Auth::id();
                $comprobantePago->estandar_id = $id;
                $comprobantePago->comprobante_pago = $filePath;
                $comprobantePago->estado = json_encode(['comprobante' => 'pendiente']);
                $comprobantePago->save();
            }

            // Actualizar o crear validación de comprobante
            $validacionComentario = ValidacionesCertificaciones::where('comprobante_id', $comprobantePago->id)
                ->where('user_id', Auth::id())
                ->first();

            if ($validacionComentario) {
                $validacionComentario->update([
                    'tipo_documento' => 'comprobante',
                    'tipo_validacion' => 'pendiente',
                    'user_id' => Auth::id(),
                ]);
            } else {
                ValidacionesCertificaciones::create([
                    'comprobante_id' => $comprobantePago->id,
                    'tipo_documento' => 'comprobante',
                    'tipo_validacion' => 'pendiente',
                    'user_id' => Auth::id(),
                ]);
            }

            return redirect()->route('evidenciasEC.index', ['id' => $id, 'name' => $estandarName])->with('success', 'Comprobante de pago resubido correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar el archivo: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Error al guardar el archivo: ' . $e->getMessage()]);
        }
    }
}
