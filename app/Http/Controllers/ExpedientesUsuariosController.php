<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SurveyResponse; // Asegúrate de importar el modelo SurveyResponse
use Illuminate\Http\Request;
use App\Models\AtencionUsuario;
use Illuminate\Support\Facades\Auth;

class ExpedientesUsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Mostrar la lista de usuarios asignados.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Obtener el evaluador autenticado
        $evaluadorId = Auth::user()->id;

        // Obtener solo los usuarios asignados a este evaluador
        $usuariosAsignados = User::whereHas('evaluadores', function ($query) use ($evaluadorId) {
            $query->where('evaluador_id', $evaluadorId);
        })->with('documentos')->get();

        // Renderizar la vista con la lista de usuarios asignados
        return view('expedientes.expedientesAdmin.usuarios.index', compact('usuariosAsignados'));
    }

    public function show($id)
    {
        $usuariosAdmin = User::with('documentos.validacionesComentarios', 'comprobantesCU', 'comprobantesCO', 'estandares', 'cursos')->findOrFail($id);

        // Recuperar documentos, comprobantes, estándares y cursos
        $documentos = $usuariosAdmin->documentos;
        $comprobantesCO = $usuariosAdmin->comprobantesCO; // Comprobantes de pago competencia
        $comprobantesCU = $usuariosAdmin->comprobantesCU; // Comprobantes de pago curso
        $estandares = $usuariosAdmin->estandares;
        $cursos = $usuariosAdmin->cursos;

        // Recuperar respuestas de encuestas y cargar la relación estandar
        $surveyResponses = SurveyResponse::where('user_id', $id)->with('estandar')->get();
        $atencionUsuario = AtencionUsuario::where('user_id', $id)->with('estandar')->get();

        // Comprobar el estado de los documentos
        $documentosCompletos = true;
        $documentosEnValidacion = false;

        foreach ($documentos as $documento) {
            $estado = json_decode($documento->estado, true) ?? [];

            // Comprobar si algún documento está en estado 'Pendiente' o 'rechazar'
            $documentosEnValidacion = in_array('Pendiente', $estado) || in_array('rechazar', $estado);

            // Comprobar si todos los documentos están validados
            $documentosCompletos = !in_array('validar', $estado) ? false : $documentosCompletos;
        }

        // Variables para comprobar los comprobantes de pago
        $comprobanteSubidoCO = $comprobantesCO->isNotEmpty();
        $comprobanteEnValidacionCO = false;
        $comprobanteValidadoCO = true; // Asumimos inicialmente que todos están validados

        if ($comprobanteSubidoCO) {
            foreach ($comprobantesCO as $comprobanteCO) {
                $estado = json_decode($comprobanteCO->estado, true) ?? [];

                // Filtra comprobantes con estado null y considera estos como no validados
                if ($estado === null || (isset($estado['comprobante_pago']) && $estado['comprobante_pago'] === 'Pendiente')) {
                    $comprobanteEnValidacionCO = true;
                    $comprobanteValidadoCO = false;
                    break;
                }
            }
        }

        $comprobanteSubidoCU = $comprobantesCU->isNotEmpty();
        $comprobanteEnValidacionCU = false;
        if ($comprobanteSubidoCU) {
            foreach ($comprobantesCU as $comprobanteCU) {
                $estado = json_decode($comprobanteCU->estado, true) ?? [];
                $comprobantePagoStatusCU = $estado['comprobante_pago'] ?? null;

                if ($comprobantePagoStatusCU === 'Pendiente') {
                    $comprobanteEnValidacionCU = true;
                    break;
                }
            }
        }

        return view('expedientes.expedientesAdmin.usuarios.show', compact(
            'usuariosAdmin',
            'documentos',
            'comprobantesCU',
            'comprobantesCO',
            'estandares',
            'cursos',
            'documentosCompletos',
            'documentosEnValidacion',
            'comprobanteSubidoCO',
            'comprobanteSubidoCU',
            'comprobanteEnValidacionCU',
            'comprobanteEnValidacionCO',
            'comprobanteValidadoCO',
            'surveyResponses',
            'atencionUsuario'
        ));
    }



    /**
     * Show the expediente for the specified user.
     */
    public function showExpediente($user_id)
    {
        $usuario = User::findOrFail($user_id);
        $atencionUsuario = AtencionUsuario::where('user_id', $user_id)->with('estandar')->get();
        // Recuperar todas las respuestas de encuesta para el usuario y cargar la relación estandar
        $surveyResponses = SurveyResponse::where('user_id', $user_id)->with('estandar')->get();

        return view('expedientes.show', compact('usuario', 'surveyResponses', 'atencionUsuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $usuariosAdmin = User::findOrFail($id);

        return view('expedientes.expedientesAdmin.usuarios.edit', compact('usuariosAdmin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Definir las reglas de validación
        $rules = [
            'name' => 'required|string|max:255',
            'secondName' => 'required|string|max:255',
            'paternalSurname' => 'required|string|max:255',
            'maternalSurname' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            // Otras reglas de validación si es necesario
        ];

        // Validar la solicitud
        $validatedData = $request->validate($rules);

        // Encontrar el usuario por ID
        $usuariosAdmin = User::findOrFail($id);

        // Actualizar el usuario con los datos validados
        $usuariosAdmin->update($validatedData);

        // Redirigir a la vista de índice con un mensaje de éxito
        return redirect()->route('usuariosAdmin.show', ['usuariosAdmin' => $id])
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function actualizarContenido($id)
    {
        $usuariosAdmin = User::with('documentos.validacionesComentarios', 'comprobantesCU', 'comprobantesCO', 'estandares', 'cursos')->findOrFail($id);

        $documentos = $usuariosAdmin->documentos;
        $comprobantesCU = $usuariosAdmin->comprobantesCU;
        $comprobantesCO = $usuariosAdmin->comprobantesCO;
        $estandares = $usuariosAdmin->estandares;
        $cursos = $usuariosAdmin->cursos;

        $documentosCompletos = true;
        $documentosEnValidacion = false;

        foreach ($documentos as $documento) {
            $validaciones = $documento->validacionesComentarios;

            if ($validaciones->isEmpty()) {
                // Si no hay validaciones, consideramos que el documento está en proceso
                $documentosCompletos = false;
                $documentosEnValidacion = true;
                continue;
            }

            $documentoCompletado = $validaciones->every(function ($validacion) {
                return $validacion->tipo_validacion === 'validar';
            });

            $documentoEnValidacion = $validaciones->contains(function ($validacion) {
                return $validacion->tipo_validacion === 'Pendiente';
            });

            if ($documentoEnValidacion) {
                $documentosEnValidacion = true;
            }

            if (!$documentoCompletado) {
                $documentosCompletos = false;
            }
        }

        $comprobanteSubidoCO = $comprobantesCO->isNotEmpty();
        $comprobanteEnValidacionCO = false;
        if ($comprobanteSubidoCO) {
            foreach ($comprobantesCO as $comprobanteCO) {
                $estado = json_decode($comprobanteCO->estado, true) ?? [];
                $comprobantePagoStatusCO = $estado['comprobante_pago'] ?? null;

                if ($comprobantePagoStatusCO === 'Pendiente') {
                    $comprobanteEnValidacionCO = true;
                    break;
                }
            }
        }

        $comprobanteSubidoCU = $comprobantesCU->isNotEmpty();
        $comprobanteEnValidacionCU = false;
        if ($comprobanteSubidoCU) {
            foreach ($comprobantesCU as $comprobanteCU) {
                $estado = json_decode($comprobanteCU->estado, true) ?? [];
                $comprobantePagoStatusCU = $estado['comprobante_pago'] ?? null;

                if ($comprobantePagoStatusCU === 'Pendiente') {
                    $comprobanteEnValidacionCU = true;
                    break;
                }
            }
        }

        return view('expedientes.expedientesAdmin.usuarios.contenido', compact('usuariosAdmin', 'documentos', 'comprobantesCU', 'comprobantesCO', 'estandares', 'cursos', 'documentosCompletos', 'documentosEnValidacion', 'comprobanteSubidoCO', 'comprobanteSubidoCU', 'comprobanteEnValidacionCU', 'comprobanteEnValidacionCO'));
    }
}
