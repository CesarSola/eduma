<?php

namespace App\Http\Controllers;

use App\Models\ComprobantesCU;
use App\Models\User;
use App\Models\ValidacionesComentarios;
use Illuminate\Http\Request;

class ValidarCuPController extends Controller
{
    // Método para mostrar la vista de revisión de comprobantes de pago
    public function show($id)
    {
        // Obtener el usuario junto con los comprobantes
        $usuarioCU = User::with('comprobantesCU.validacionesComentarios')->findOrFail($id);

        // Filtrar comprobantes específicos que necesitan revisión
        $comprobantesCU = $usuarioCU->comprobantesCU->filter(function ($comprobanteCU) {
            return $comprobanteCU->validacionesComentarios->isEmpty() || $comprobanteCU->validacionesComentarios->contains(function ($validacionCU) {
                return $validacionCU->tipo_validacion != 'validar';
            });
        });

        return view('expedientes.expedientesAdmin.validarCuP.show', compact('usuarioCU', 'comprobantesCU'));
    }

    // Método para actualizar el estado de validación de un comprobante de pago
    public function updateComprobante(Request $request, $id, $comprobanteId)
    {
        $usuarioCU = User::findOrFail($id);
        $comprobanteCU = ComprobantesCU::findOrFail($comprobanteId);

        $accion = $request->input('documento_estado_CU');
        $comentario = $request->input('comentario_documento', '');

        // Verificar que el comprobante de pago pertenezca al usuario
        if ($comprobanteCU->user_id == $usuarioCU->id) {
            // Update or create validation
            ValidacionesComentarios::updateOrCreate(
                [
                    'user_id' => $usuarioCU->id,
                    'comprobanteCU_id' => $comprobanteCU->id,
                    'tipo_documento' => 'comprobante_pago' // Asegúrate de usar el tipo de documento correcto
                ],
                [
                    'tipo_validacion' => $accion,
                    'comentario' => $comentario
                ]
            );

            // Actualizar el estado de validación en el estado del comprobante
            $estado = json_decode($comprobanteCU->estado, true) ?? [];
            $estado['validacion_comprobante_pago'] = $accion; // Asegúrate de usar el campo de estado correcto
            $comprobanteCU->estado = json_encode($estado);
            $comprobanteCU->save();

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
