<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\FechaCompetencia;
use App\Models\Horario;
use App\Models\User;
use Illuminate\Http\Request;


class FechasController extends Controller
{

    public function store(Request $request, $competenciaId)
    {
        // Validar los datos
        $request->validate([
            'usuario_id' => 'required|exists:users,id',
            'estandar_id' => 'required|exists:estandares,id',
            'fechas' => 'required|array',
            'fechas.*.fecha' => 'required|date',
            'fechas.*.hora' => 'required|array',
            'fechas.*.hora.*' => 'required|date_format:H:i',
        ]);

        $userId = $request->input('usuario_id');
        $estandarId = $request->input('estandar_id');
        $fechas = $request->input('fechas');

        // Guardar fechas
        $fechaIds = [];
        foreach ($fechas as $index => $fecha) {
            $fechaCompetencia = FechaCompetencia::create([
                'user_id' => $userId,
                'competencia_id' => $estandarId,
                'fecha' => $fecha['fecha'],
            ]);

            $fechaIds[] = $fechaCompetencia->id;
        }

        // Guardar horarios asociados a las fechas
        foreach ($fechas as $index => $fecha) {
            foreach ($fecha['hora'] as $hora) {
                Horario::create([
                    'user_id' => $userId,
                    'competencia_id' => $estandarId,
                    'hora' => $hora,
                    'fecha_competencia_id' => $fechaIds[$index],
                ]);
            }
        }

        return response()->json(['success' => true]);
    }
}
