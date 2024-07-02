<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ComprobantesCO;
use App\Models\ValidacionesComentarios;
use Illuminate\Http\Request;

class ValidarCoPController extends Controller
{
    public function show($id)
    {
        $usuario = User::findOrFail($id);
        // Encuentra el comprobante de pago más reciente relacionado con el tipo especificado
        $comprobanteCO = ComprobantesCO::where('user_id', $id)->first(); // Asegúrate de obtener el primer resultado correctamente

        return view('expedientes.expedientesAdmin.validarCoP.show', compact('usuario', 'comprobanteCO'));
    }



    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $estandarId = $request->input('estandar_id'); // Asumiendo que recibes el ID del estándar
        $cursoId = $request->input('curso_id'); // Asumiendo que recibes el ID del curso

        // Validar y procesar el archivo subido
        if ($request->hasFile('comprobante_pago')) {
            $file = $request->file('comprobante_pago');
            $filename = $file->getClientOriginalName();
            $path = 'public/documents/records/payments/users/' . $usuario->name;

            // Guardar el archivo en la carpeta del usuario con el nombre original
            $filePath = $file->storeAs($path, $filename);

            // Buscar y actualizar el comprobante de pago más reciente relacionado con estándar y curso
            $comprobanteCO = ComprobantesCO::where('user_id', $id)
                ->where('estandar_id', $estandarId)
                ->where('curso_id', $cursoId)
                ->latest()
                ->first();

            if (!$comprobanteCO) {
                abort(404, 'Comprobante de pago no encontrado.');
            }

            $comprobanteCO->update(['comprobante_pago' => $filePath]);

            $accion = $request->input('documento_estado');
            $comentario = $request->input('comentario_documento', '');

            // Actualizar el estado y comentarios del comprobante de pago
            $estado = json_decode($comprobanteCO->estado, true) ?? [];
            $estado['comprobante_pago'] = $accion;
            $comprobanteCO->update(['estado' => json_encode($estado)]);

            ValidacionesComentarios::updateOrCreate(
                [
                    'user_id' => $usuario->id,
                    'comprobante_pago_id' => $comprobanteCO->id,
                    'tipo_documento' => 'comprobante_pago'
                ],
                [
                    'tipo_validacion' => $accion,
                    'comentario' => $comentario
                ]
            );

            // Mensaje de éxito y respuesta JSON
            if ($accion == 'validar') {
                $mensaje = 'Comprobante de pago validado correctamente';
            } else {
                $mensaje = 'Comprobante de pago rechazado correctamente';
            }
            return response()->json(['success' => $mensaje]);
        } else {
            return response()->json(['error' => 'No se ha subido ningún archivo.']);
        }
    }
}
