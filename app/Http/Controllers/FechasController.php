<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\FechaCompetencia;
use App\Models\FechaElegida;
use App\Models\Horario;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Spatie\Permission\Models\Role;

class FechasController extends Controller
{
    public function show(Request $request, $competenciaId)
    {
        // Obtener todos los usuarios con sus estándares
        $usuarios = User::with('estandares')->get();

        // Obtener la competencia por ID
        $competencia = Estandares::findOrFail($competenciaId);

        // Obtener el user_id de la solicitud (si existe)
        $selectedUserId = $request->input('user_id', null);

        // Inicializar array para estándares con fechas
        $estandaresConFechas = [];

        if ($selectedUserId) {
            // Obtener el usuario seleccionado
            $user = User::findOrFail($selectedUserId);

            foreach ($user->estandares as $estandar) {
                // Verificar si el estándar tiene fechas asignadas
                $tieneFechas = FechaCompetencia::where('competencia_id', $estandar->id)->exists();
                if (!$tieneFechas) {
                    $estandaresConFechas[] = $estandar->id; // Guardar estándares sin fechas
                }
            }
        } else {
            // Si no se pasa user_id, obtener todos los estándares sin fechas
            $estandares = Estandares::all();

            foreach ($estandares as $estandar) {
                // Verificar si el estándar tiene fechas asignadas
                $tieneFechas = FechaCompetencia::where('competencia_id', $estandar->id)->exists();
                if (!$tieneFechas) {
                    $estandaresConFechas[] = $estandar->id; // Guardar estándares sin fechas
                }
            }
        }

        // Enviar los datos a la vista
        return view('expedientes.expedientesAdmin.competencias.fechas.agregar-fechas', [
            'usuarios' => $usuarios,
            'competencia' => $competencia,
            'selectedUserId' => $selectedUserId,
            'estandaresConFechas' => $estandaresConFechas,
            'estandares' => $estandares ?? [], // Asegúrate de pasar `$estandares`
        ]);
    }


    public function store(Request $request, $competenciaId)
    {
        // Validar los datos
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'estandar_id' => 'required|exists:estandares,id',
            'fechas' => 'required|array',
            'fechas.*' => 'required|date',
            'horarios' => 'required|array',
            'horarios.*.*' => 'required|date_format:H:i',
        ]);

        $userId = $request->input('usuario_id');
        $competenciaId = $request->input('estandar_id');
        $fechas = $request->input('fechas');
        $horarios = $request->input('horarios');

        // Guardar fechas
        $fechaIds = [];
        foreach ($fechas as $index => $fecha) {
            $fechaCompetencia = FechaCompetencia::create([
                'user_id' => $userId,
                'competencia_id' => $competenciaId,
                'fecha' => $fecha,
            ]);

            $fechaIds[] = $fechaCompetencia->id;
        }

        // Guardar horarios asociados a las fechas
        foreach ($horarios as $index => $horarioArray) {
            foreach ($horarioArray as $hora) {
                Horario::create([
                    'user_id' => $userId,
                    'competencia_id' => $competenciaId,
                    'hora' => $hora,
                    'fecha_competencia_id' => $fechaIds[$index],
                ]);
            }
        }

        return redirect()->back()->with('success', 'Fechas y horarios guardados exitosamente.');
    }
}
