<?php

namespace App\Http\Controllers;

use App\Models\AutoDiag;

use App\Models\Curso;
use App\Models\DocumentosUser;
use App\Models\Estandares;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $usuario = Auth::user();

            // Verificar si el correo ha sido verificado
            if (is_null($usuario->email_verified_at)) {
                return redirect()->route('verification.notice');
            }
        } else {
            return redirect()->route('login');
        }

        // Obtener todos los documentos del usuario con sus validaciones
        $documentos = DocumentosUser::where('user_id', $usuario->id)
            ->with('validacionesComentarios')
            ->get();

        // Filtrar los documentos rechazados
        $documentosRechazados = $documentos->filter(function ($documento) {
            $estado = json_decode($documento->estado, true) ?? [];
            foreach (['foto', 'ine_ife', 'comprobante_domiciliario', 'curp'] as $tipo_documento) {
                if (isset($estado[$tipo_documento]) && $estado[$tipo_documento] == 'rechazar') {
                    return true;
                }
            }
            return false;
        });

        $competencias = Estandares::all();
        $cursos = Curso::all();
        $autodiagnosticos = AutoDiag::all(); // Obtener los autodiagnósticos

        return view('expedientes.expedientesUser.dashboardUser.index', compact('usuario', 'cursos', 'competencias', 'documentos', 'documentosRechazados', 'autodiagnosticos'));
    }
}
