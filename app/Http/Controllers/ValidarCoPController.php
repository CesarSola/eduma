<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ComprobantePago;
use App\Models\ComprobantesCO;
use App\Models\ValidacionesComentarios;
use App\Models\ValidacionesComprobantesCompetencias;
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
            return $comprobanteCO->validaciones->isEmpty() || $comprobanteCO->validaciones->contains(function ($validacion) {
                return $validacion->tipo_validacion != 'validar';
            });
        });

        return view('expedientes.expedientesAdmin.validarCoP.show', compact('usuarioCO', 'comprobantesCO'));
    }

    public function updateComprobante(Request $request, $id, $comprobanteId)
    {
        $usuarioCO = User::findOrFail($id);
        $comprobantesCO = ComprobantesCO::findOrFail($comprobanteId);

        $accion = $request->input('documento_estado');
        $comentario = $request->input('comentario_documento', '');

        // Verificar que el comprobante de pago pertenezca al usuario
        if ($comprobantesCO->user_id == $usuarioCO->id) {
            // Buscar la validación existente
            $validacion = ValidacionesComprobantesCompetencias::where([
                'comprobante_id' => $comprobantesCO->id,
                'user_id' => $usuarioCO->id
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
                ValidacionesComprobantesCompetencias::create([
                    'comprobante_id' => $comprobantesCO->id,
                    'user_id' => $usuarioCO->id,
                    'tipo_documento' => 'comprobante',
                    'tipo_validacion' => $accion,
                    'comentario' => $comentario
                ]);
            }

            // Actualizar el estado de validación en el estado del comprobante
            $estado = json_decode($comprobantesCO->estado, true) ?? [];
            $estado['validacion_comprobante_pago'] = $accion; // Asegúrate de usar el campo de estado correcto
            $comprobantesCO->estado = json_encode($estado);
            $comprobantesCO->save();

            // Retornar una respuesta JSON con el mensaje apropiado
            $mensaje = $accion === 'validar' ? 'Comprobante de pago validado correctamente' : 'Comprobante de pago rechazado correctamente';
            return response()->json(['success' => $mensaje]);
        } else {
            return response()->json(['error' => 'No tienes permiso para modificar este comprobante de pago.'], 403);
        }
    }
}
