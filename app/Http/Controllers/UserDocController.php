<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserDocController extends Controller
{
    public function index()
    {
        // Obtener solo los usuarios con rol 'User' y sus documentos, excluyendo a los de rol 'Admin'
        $usuarios = User::role('User')
            ->whereDoesntHave('roles', function ($query) {
                $query->where('name', 'Admin');
            })
            ->with('documentos.validacionesComentarios')
            ->paginate(10);

        // Verificar el estado de los documentos de cada usuario
        foreach ($usuarios as $usuario) {
            $documentos = $usuario->documentos;
            $todosDocumentosValidados = true;

            // Si el usuario no tiene documentos, los documentos no están validados
            if ($documentos->isEmpty()) {
                $todosDocumentosValidados = false;
            } else {
                foreach ($documentos as $documento) {
                    // Revisar el estado en la tabla de documentos
                    $estado = json_decode($documento->estado, true) ?? [];

                    // Si no hay estado, el documento no está validado
                    if (empty($estado)) {
                        $todosDocumentosValidados = false;
                        break;
                    }

                    // Revisar la tabla de validaciones para ver si hay algún documento rechazado o pendiente
                    foreach ($documento->validacionesComentarios as $validacion) {
                        if ($validacion->tipo_validacion === 'rechazar' || $validacion->tipo_validacion === 'Pendiente') {
                            $todosDocumentosValidados = false;
                            break 2; // Salimos de ambos bucles
                        }
                    }
                }
            }

            // Agregar una propiedad al usuario para indicar si todos los documentos están validados
            $usuario->todosDocumentosValidados = $todosDocumentosValidados;
        }

        // Renderizar la vista con la lista de usuarios y sus documentos
        return view('expedientes.validarDocUsers.index', compact('usuarios'));
    }
}
