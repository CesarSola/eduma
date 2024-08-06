<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\FechaCompetencia;
use App\Models\FechaElegida;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class CalendarioController extends Controller
{

    public function index($competenciaId, Request $request)
    {
        $userId = $request->query('user_id');
        // Obtener la competencia por ID utilizando el modelo Estandares.
        $competencia = Estandares::findOrFail($competenciaId);

        // Obtener todos los usuarios sin el rol de administrador y cargar sus estándares
        $usuarios = $this->getUsuariosSinRolAdmin();

        // Si quieres cargar también los estándares de los usuarios, puedes hacerlo aquí
        $usuarios = $usuarios->load('estandares');
        // Ejemplo de cómo podrías recuperar las fechas en el controlador
        $fechasDisponibles = FechaCompetencia::with('competencia', 'horarios', 'user')->get();
        $fechasElegidas = FechaElegida::with('fechaCompetencia', 'horarioCompetencia', 'user')->get();

        // Obtener el user_id de la solicitud, si se proporciona. Si no se proporciona, se usa null como valor predeterminado.
        $selectedUserId = $request->input('user_id', null);


        // Retornar la vista 'expedientes.expedientesAdmin.competencias.fechas.show' con los datos necesarios.
        return view('expedientes.expedientesAdmin.competencias.fechas.show', [
            'competencia' => $competencia,
            'fechasDisponibles' => $fechasDisponibles,
            'fechasElegidas' => $fechasElegidas,
            'selectedUserId' => $selectedUserId,
            'usuarios' => $usuarios,
            'competencias' => $competencia,
        ]);
    }

    public function getUsuariosSinRolAdmin()
    {
        $adminRole = Role::where('name', 'admin')->first();

        // Obtener solo los usuarios que no tienen el rol de administrador
        return User::whereDoesntHave('roles', function ($query) use ($adminRole) {
            $query->where('role_id', $adminRole->id);
        })->with('documentos')->get(); // No es necesario el with aquí
    }
}
