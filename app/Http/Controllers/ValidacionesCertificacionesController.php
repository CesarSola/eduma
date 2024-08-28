<?php

namespace App\Http\Controllers;

use App\Models\ComprobanteCertificacion;
use App\Models\Estandares;
use App\Models\User;
use App\Models\ValidacionesCertificaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ValidacionesCertificacionesController extends Controller
{
    public function show($id, Request $request)
    {
        // Obtener el usuario basado en el ID
        $usuarioCE = User::findOrFail($id);

        // Obtener los parámetros de consulta opcionales
        $userId = $request->query('user_id');
        $competenciaId = $request->query('competencia');

        // Si no se proporciona user_id, usar el usuario autenticado
        $usuario = $userId ? User::findOrFail($userId) : Auth::user();

        // Obtener la competencia basada en el ID
        $competencia = Estandares::findOrFail($competenciaId);

        // Filtrar comprobantes específicos que necesitan revisión
        $comprobantesCE = $usuarioCE->comprobantesCE->filter(function ($comprobanteCE) {
            return $comprobanteCE->validaciones->isEmpty() || $comprobanteCE->validaciones->contains(function ($validacion) {
                return $validacion->tipo_validacion != 'validar';
            });
        });

        // Devolver la vista con los datos necesarios
        return view('expedientes.expedientesAdmin.validarCE.show', compact('usuarioCE', 'comprobantesCE', 'competencia'));
    }

    public function updateCertificados(Request $request, $id, $comprobanteId)
    {
        $usuarioCE = User::findOrFail($id);
        $comprobantesCE = ComprobanteCertificacion::findOrFail($comprobanteId);

        $accion = $request->input('documento_estado');
        $comentario = $request->input('comentario_documento', '');

        // Verificar que el comprobante de pago pertenezca al usuario
        if ($comprobantesCE->user_id == $usuarioCE->id) {
            // Buscar la validación existente
            $validacion = ValidacionesCertificaciones::where([
                'comprobante_id' => $comprobantesCE->id,
                'user_id' => $usuarioCE->id
            ])->first();

            if ($validacion) {
                // Actualizar el registro existente
                $validacion->update([
                    'tipo_documento' => 'comprobante',
                    'tipo_validacion' => $accion,
                    'comentario' => $comentario
                ]);
            } else {
                // Crear un nuevo registro si no existe
                ValidacionesCertificaciones::create([
                    'comprobante_id' => $comprobantesCE->id,
                    'user_id' => $usuarioCE->id,
                    'tipo_documento' => 'comprobante',
                    'tipo_validacion' => $accion,
                    'comentario' => $comentario
                ]);
            }

            // Actualizar el estado de validación en el estado del comprobante
            $estado = json_decode($comprobantesCE->estado, true) ?? [];

            // Actualizar el campo 'comprobante' con el nuevo valor
            $estado['comprobante'] = $accion;

            // Eliminar otros campos de estado si se necesita
            // Ejemplo: Si solo deseas conservar 'comprobante' y 'validacion_comprobante_pago', puedes hacerlo
            // $estado = [
            //     'comprobante' => $accion,
            //     'validacion_comprobante_pago' => $estado['validacion_comprobante_pago'] ?? null
            // ];

            $comprobantesCE->estado = json_encode($estado);
            $comprobantesCE->save();

            // Marcar el comprobante como "no revisable" si ha sido rechazado
            if ($accion === 'rechazar') {
                $estado['revisable'] = false;
                $comprobantesCE->estado = json_encode($estado);
                $comprobantesCE->save();
            }

            // Retornar una respuesta JSON con el mensaje apropiado
            $mensaje = $accion === 'validar' ? 'Comprobante de pago validado correctamente' : 'Comprobante de pago rechazado correctamente';
            return response()->json(['success' => $mensaje]);
        } else {
            return response()->json(['error' => 'No tienes permiso para modificar este comprobante de pago.'], 403);
        }
    }
}
