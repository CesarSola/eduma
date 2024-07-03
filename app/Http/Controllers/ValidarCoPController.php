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
        $usuarioCO = User::findOrFail($id);

        // Filtrar comprobantes específicos que necesitan revisión
        $comprobantesCO = $usuarioCO->comprobantesCO->filter(function ($comprobanteCO) {
            return $comprobanteCO->validacionesComentarios->isEmpty() || $comprobanteCO->validacionesComentarios->contains(function ($validacion) {
                return $validacion->tipo_validacion != 'validar';
            });
        });

        return view('expedientes.expedientesAdmin.validarCoP.show', compact('usuarioCO', 'comprobantesCO'));
    }

    // Método para actualizar el estado de validación de un comprobante de pago
    public function updateComprobante(Request $request, $id, $comprobanteId)
    {
        $usuarioCO = User::findOrFail($id);
        $comprobantesCO = ComprobantesCO::findOrFail($comprobanteId);

        $accion = $request->input('documento_estado');
        $comentario = $request->input('comentario_documento', '');

        // Verificar que el comprobante de pago pertenezca al usuario
        if ($comprobantesCO->user_id == $usuarioCO->id) {
            // Update or create validation
            ValidacionesComentarios::updateOrCreate(
                [
                    'user_id' => $usuarioCO->id,
                    'comprobanteCO_id' => $comprobantesCO->id,
                    'tipo_documento' => 'comprobante_pago' // Asegúrate de usar el tipo de documento correcto
                ],
                [
                    'tipo_validacion' => $accion,
                    'comentario' => $comentario
                ]
            );

            // Actualizar el estado de validación en el estado del comprobante
            $estado = json_decode($comprobantesCO->estado, true) ?? [];
            $estado['validacion_comprobante_pago'] = $accion; // Asegúrate de usar el campo de estado correcto
            $comprobantesCO->estado = json_encode($estado);
            $comprobantesCO->save();

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
