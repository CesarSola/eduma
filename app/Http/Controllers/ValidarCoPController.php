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
            return $comprobanteCO->validacionesComentarios->isEmpty() || $comprobanteCO->validacionesComentarios->contains(function ($validacionCU) {
                return $validacionCU->tipo_validacion != 'validar';
            });
        });

        return view('expedientes.expedientesAdmin.validarCoP.show', compact('usuarioCO', 'comprobantesCO'));
    }

    // Método para actualizar el estado de validación de un comprobante de pago
    public function updateComprobante(Request $request, $id, $comprobanteId)
    {
        $usuarioCO = User::findOrFail($id);
        $ComprobanteCO = ComprobantesCO::findOrFail($comprobanteId);

        $accionCO = $request->input('documento_estado');
        $comentarioCO = $request->input('comentario_documento', '');

        // Verificar que el comprobante de pago pertenezca al usuario
        if ($ComprobanteCO->user_id == $usuarioCO->id) {
            // Update or create validation
            ValidacionesComentarios::updateOrCreate(
                [
                    'user_id' => $usuarioCO->id,
                    'comprobanteCO_id' => $ComprobanteCO->id,
                    'tipo_documento' => 'comprobante_pago' // Asegúrate de usar el tipo de documento correcto
                ],
                [
                    'tipo_validacion' => $accionCO,
                    'comentario' => $comentarioCO
                ]
            );

            // Actualizar el estado de validación en el estado del comprobante
            $estadoCO = json_decode($ComprobanteCO->estadoCO, true) ?? [];
            $estadoCO['validacion_comprobante_pago'] = $accionCO; // Asegúrate de usar el campo de estadoCO correcto
            $ComprobanteCO->estadoCO = json_encode($estadoCO);
            $ComprobanteCO->save();

            // Retornar una respuesta JSON con el mensaje apropiado
            if ($accionCO == 'validar') {
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
