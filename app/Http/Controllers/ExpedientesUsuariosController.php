<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class ExpedientesUsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $adminRole = Role::where('name', 'admin')->first();

        // Obtener solo los usuarios que no tienen el rol de administrador
        $usuariosAdmin = User::whereDoesntHave('roles', function ($query) use ($adminRole) {
            $query->where('role_id', $adminRole->id);
        })->with('documentos')->get();

        // Renderizar la vista con la lista de usuarios
        return view('expedientes.expedientesAdmin.usuarios.index', compact('usuariosAdmin'));
    }
    public function show($id)
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

        return view('expedientes.expedientesAdmin.usuarios.show', compact('usuariosAdmin', 'documentos', 'comprobantesCU', 'comprobantesCO', 'estandares', 'cursos', 'documentosCompletos', 'documentosEnValidacion', 'comprobanteSubidoCO', 'comprobanteSubidoCU', 'comprobanteEnValidacionCU', 'comprobanteEnValidacionCO'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mostrar el formulario de creación de un nuevo recurso

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        // Crear un nuevo usuario con los datos validados
        User::create($validatedData);

        // Redirigir a la vista de índice con un mensaje de éxito
        return redirect()->route('usuariosAdmin.index')
            ->with('success', 'Usuario creado correctamente');
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
        return redirect()->route('usuariosAdmin.index')
            ->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $usuariosAdmin = User::findOrFail($id);

        // Eliminar el usuario
        $usuariosAdmin->delete();

        // Redirigir a la vista de índice con un mensaje de éxito
        return redirect()->route('usuariosAdmin.index')
            ->with('success', 'Usuario eliminado correctamente');
    }
}
