<?php

namespace App\Http\Controllers;

use App\Models\ComprobantesCO;
use App\Models\Estandares;
use App\Models\User;
use App\Models\ValidacionesComentarios;
use App\Models\ValidacionesComprobantesCompetencias;
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
        // Obtener el usuario autenticado
        $user = auth()->user();

        // Si el usuario no está autenticado, redirigir a la página de inicio de sesión
        if (!$user) {
            return redirect()->route('login')->with('error', 'Por favor inicia sesión para acceder a tus competencias.');
        }

        $userId = $user->id; // Obtén el ID del usuario autenticado

        // Obtener todos los estándares del usuario con comprobantes y validaciones
        $competencias = Estandares::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
            ->with(['comprobantesCO.validaciones'])
            ->get();

        return view('expedientes.expedientesUser.competencias.index', compact('competencias', 'user'));
    }


    /**
     * Mostrar la vista para re-subir el comprobante de pago rechazado.
     */
    public function mostrarRechazado($id)
    {
        $competencia = Estandares::findOrFail($id);
        $validacionComentario = ValidacionesComprobantesCompetencias::where('comprobante_id', $competencia->id)
            ->where('comprobante_id', 'tipo_validacion')
            ->first();

        // Si no hay validación de comprobante, podemos manejarlo como necesario
        return view('expedientes.expedientesUser.competencias.resubir_comprobante', compact('competencia', 'validacionComentario'));
    }
    public function guardarResubirComprobante(Request $request, $id)
    {
        $estandar = Estandares::findOrFail($id);
        $comprobantePago = $estandar->comprobantesCO()->first();

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

            $folderPath = 'documents/records/payments/competences/standards/' .
                $userMatricula . '/' .
                $userName . ' ' .
                $userSecondName . ' ' .
                $userPaternalSurname . ' ' .
                $userMaternalSurname;

            $fileName = 'Comprobante_Pago_' . str_replace(' ', '_', $estandar->name) . '.' . $nuevoComprobante->getClientOriginalExtension();
            $filePath = $nuevoComprobante->storeAs($folderPath, $fileName, 'public');

            $fullPath = storage_path('app/public/' . $filePath);

            Log::info('Archivo almacenado en: ' . $filePath);
            Log::info('Ruta completa del archivo: ' . $fullPath);

            if (file_exists($fullPath)) {
                Log::info('El archivo realmente existe en la ruta: ' . $fullPath);
            } else {
                Log::error('El archivo no se encuentra en la ruta esperada: ' . $fullPath);
            }

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
            }

            // Actualizar o crear validación de comprobante
            $user_id = Auth::id();
            $validacionComentario = ValidacionesComprobantesCompetencias::where('comprobante_id', $comprobantePago->id)->first();

            if ($validacionComentario) {
                $validacionComentario->update([
                    'tipo_documento' => 'comprobante',
                    'tipo_validacion' => 'pendiente',
                    'user_id' => $user_id,
                ]);
            } else {
                ValidacionesComprobantesCompetencias::create([
                    'comprobante_id' => $comprobantePago->id,
                    'tipo_documento' => 'comprobante',
                    'tipo_validacion' => 'pendiente',
                    'user_id' => $user_id,
                ]);
            }

            return redirect()->route('miscompetencias.index')->with('success', 'Comprobante de pago re-enviado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al guardar el archivo: ' . $e->getMessage());
            return back()->withInput()->withErrors(['error' => 'Error al guardar el archivo: ' . $e->getMessage()]);
        }
    }
}
