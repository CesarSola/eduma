<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ComprobantePago;
use App\Models\ComprobantesCO;
use App\Models\ValidacionesComentarios;
use Illuminate\Http\Request;

class ValidarCoPController extends Controller
{
    // Método para mostrar la vista de revisión de comprobantes de pago
    public function show($id)
    {
        // Obtener todos los comprobantes de pago del usuario
        $usuario = User::findOrFail($id);

        // Filtrar comprobantes específicos que necesitan revisión
        $comprobantes = $usuario->comprobantesCO->filter(function ($comprobante) {
            return $comprobante->validacionesComentarios->isEmpty() || $comprobante->validacionesComentarios->contains(function ($validacion) {
                return $validacion->tipo_validacion != 'validar';
            });
        });

        return view('expedientes.expedientesAdmin.validarCoP.show', compact('usuario', 'comprobantes'));
    }

    // Método para actualizar el estado de validación de un comprobante de pago
    public function updateComprobante(Request $request, $id, $comprobanteId)
    {
        $usuario = User::findOrFail($id);
        $comprobante = ComprobantesCO::findOrFail($comprobanteId);

        $accion = $request->input('documento_estado');
        $comentario = $request->input('comentario_documento', '');

        // Verificar que el comprobante de pago pertenezca al usuario
        if ($comprobante->user_id == $usuario->id) {
            // Update or create validation
            ValidacionesComentarios::updateOrCreate(
                [
                    'user_id' => $usuario->id,
                    'comprobanteCO_id' => $comprobante->id,
                    'tipo_documento' => 'comprobante_pago' // Asegúrate de usar el tipo de documento correcto
                ],
                [
                    'tipo_validacion' => $accion,
                    'comentario' => $comentario
                ]
            );

            // Actualizar el estado de validación en el estado del comprobante
            $estado = json_decode($comprobante->estado, true) ?? [];
            $estado['validacion_comprobante_pago'] = $accion; // Asegúrate de usar el campo de estado correcto
            $comprobante->estado = json_encode($estado);
            $comprobante->save();

            // Retornar una respuesta JSON con el mensaje apropiado
            if ($accion == 'validar') {
                $mensaje = 'Comprobante de pago validado correctamente';
            } else {
                $mensaje = 'Comprobante de pago rechazado correctamente';
            }
            return response()->json(['success' => $mensaje]);
        } else {
            return response()->json(['error' => 'No tienes permiso para modificar este comprobante de pago.'], 403);
        }
    }
}
