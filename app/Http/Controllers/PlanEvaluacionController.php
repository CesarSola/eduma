<?php

namespace App\Http\Controllers;

use App\Models\Estandares;
use App\Models\FechaElegida;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpWord\TemplateProcessor;

class PlanEvaluacionController extends Controller
{
    public function generatePlan($userId, $standardId)
    {
        // Buscar el estándar usando el número pasado en standardId
        $competencia = Estandares::where('numero', $standardId)->firstOrFail();

        // Construir el nombre del archivo de la plantilla basado en el número del estándar
        $templateFile = 'Plan_evaluacion_' . $competencia->numero . '.docx';
        $templatePath = public_path('templates/' . $templateFile);

        // Verificar si el archivo de la plantilla existe
        if (!file_exists($templatePath)) {
            abort(404, 'Template not found.');
        }

        $templateProcessor = new TemplateProcessor($templatePath);

        // Recuperar datos del usuario
        $user = User::findOrFail($userId);

        // Recuperar las fechas y horarios elegidos por el usuario para este estándar
        $fechas_elegidas = FechaElegida::where('user_id', $userId)
            ->whereHas('fechaCompetencia', function ($query) use ($competencia) {
                $query->where('competencia_id', $competencia->id);
            })
            ->with(['fechaCompetencia', 'horarioCompetencia'])
            ->get();

        // Reemplazar marcadores en la plantilla
        $templateProcessor->setValue('user_name', $user->name);
        $templateProcessor->setValue('user_secondName', $user->secondName);
        $templateProcessor->setValue('user_paternalSurname', $user->paternalSurname);
        $templateProcessor->setValue('user_maternalSurname', $user->maternalSurname);
        $templateProcessor->setValue('user_nacionalidad', $user->nacionalidad);
        $templateProcessor->setValue('user_curp', $user->curp);
        $templateProcessor->setValue('user_email', $user->email);
        $templateProcessor->setValue('user_phone', $user->phone);
        $templateProcessor->setValue('user_genero', $user->genero);
        $templateProcessor->setValue('user_nacimiento', $user->nacimiento);
        $templateProcessor->setValue('user_D_mnpio', $user->D_mnpio);
        $templateProcessor->setValue('user_d_estado', $user->d_estado);
        $templateProcessor->setValue('user_calle_avenida', $user->calle_avenida);
        $templateProcessor->setValue('user_numext', $user->numext);

        $templateProcessor->setValue('competencia_numero', $competencia->numero);
        $templateProcessor->setValue('competencia_name', $competencia->name);

        // Generar el texto de fechas y horarios
        $fechasHorariosText = "";
        foreach ($fechas_elegidas as $fecha) {
            $fechaFormatted = $fecha->fechaCompetencia ? $fecha->fechaCompetencia->fecha->format('d/m/Y') : 'Fecha no disponible';
            $hora = $fecha->horarioCompetencia ? $fecha->horarioCompetencia->hora : 'Hora no disponible';
            $fechasHorariosText .= $fechaFormatted . ' ' . $hora . "\n";
        }
        $templateProcessor->setValue('fechas_horarios', $fechasHorariosText);

        // Asegurarse de que la carpeta exista
        if (!Storage::exists('public/documents/required/form/plan/')) {
            Storage::makeDirectory('public/documents/required/form/plan/');
        }

        // Crear un nombre de archivo único usando el nombre del usuario y el número de competencia
        $fileName = 'Plan_de_evaluación_' . $user->name . ' ' . $user->secondName . ' ' . $user->paternalSurname . ' ' . $user->maternalSurname . '_' . $user->matricula . '_del_Estándar_' . $competencia->numero . '.docx';
        $outputPath = storage_path('app/public/documents/required/form/plan/' . $fileName);
        $templateProcessor->saveAs($outputPath);

        // Descargar el archivo sin eliminarlo después
        return response()->download($outputPath);
    }
}
