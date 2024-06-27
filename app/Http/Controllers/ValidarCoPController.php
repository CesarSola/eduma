<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ComprobantePago;
use App\Models\ValidacionesComentarios;
use Illuminate\Http\Request;

class ValidarCoPController extends Controller
{
    public function show($id)
    {
        $usuario = User::findOrFail($id);
        $comprobantePago = ComprobantePago::where('user_id', $id)->latest()->first();

        return view('expedientes.expedientesAdmin.validarCoP.show', compact('usuario', 'comprobantePago'));
    }

    public function update(Request $request, $id, $documentoNombre)
    {
        $usuario = User::findOrFail($id);
        $comprobantes = $usuario->comprobantes;

        $accion = $request->input('documento_estado');
        $comentario = $request->input('comentario_documento', '');

        foreach ($comprobantes as $comprobante) {
            if ($documentoNombre == 'comprobante_pago') {
                // Update or create validation for comprobante de pago
                ValidacionesComentarios::updateOrCreate(
                    [
                        'user_id' => $usuario->id,
                        'comprobante_pago_id' => $comprobante->id,
                        'tipo_documento' => 'comprobante_pago'
                    ],
                    [
                        'tipo_validacion' => $accion,
                        'comentario' => $comentario
                    ]
                );

                // Update the validation status in the comprobante's state
                $estado = json_decode($comprobante->estado, true) ?? [];
                $estado['comprobante_pago'] = $accion;
                $comprobante->update(['estado' => json_encode($estado)]);
            }
        }
        dd($request->all());

        // Return JSON response with appropriate message
        if ($accion == 'validar') {
            $mensaje = 'Documento validado correctamente';
        } else {
            $mensaje = 'Documento rechazado correctamente';
        }
        return response()->json(['success' => $mensaje]);
    }
}
