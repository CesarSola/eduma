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
            ->with('documentos')
            ->paginate(10); // Cambiado a paginate(10) para mostrar 10 usuarios por página

        // Verificar el estado de los documentos de cada usuario
        foreach ($usuarios as $usuario) {
            $documentos = $usuario->documentos;
            $todosDocumentosValidados = true;

            foreach ($documentos as $documento) {
                $estado = json_decode($documento->estado, true) ?? [];
                // Comprobar si algún documento está en estado 'Pendiente' o 'rechazar'
                if (in_array('Pendiente', $estado) || in_array('rechazar', $estado)) {
                    $todosDocumentosValidados = false;
                    break; // Si encontramos algún documento no validado, salimos del bucle
                }
            }

            // Agregar una propiedad al usuario para indicar si todos los documentos están validados
            $usuario->todosDocumentosValidados = $todosDocumentosValidados;
        }

        // Renderizar la vista con la lista de usuarios y sus documentos
        return view('expedientes.validarDocUsers.index', compact('usuarios'));
    }
}
