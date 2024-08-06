<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveyResponse;
use App\Models\Estandares;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;

class SurveyController extends Controller
{
    // Método para mostrar todas las encuestas
    public function index()
    {
        $surveys = SurveyResponse::all();
        return view('admin.surveys.index', compact('surveys'));
    }

    // Método para descargar una encuesta individual
    public function downloadIndividual($id)
    {
        $survey = SurveyResponse::with('estandar')->findOrFail($id);

        // Ruta del archivo de plantilla
        $templatePath = storage_path('app/public/ENCUESTA_DE_SATISFACCION.docx');

        // Verificar existencia del archivo de plantilla
        if (!file_exists($templatePath)) {
            return response()->json(['error' => 'Template file not found at ' . $templatePath], 404);
        }

        // Cargar el archivo de plantilla
        $templateProcessor = new TemplateProcessor($templatePath);

        // Reemplazar los marcadores de posición en el archivo de plantilla
        $questions = [
            'question1' => '1. ¿La presentación del estándar de competencia y la aplicación del diagnóstico, lo realizaron sin costo para usted?',
            'question2' => '2. ¿Le proporcionaron la información suficiente y necesaria para iniciar su proceso de evaluación?',
            'question3' => '3. ¿Durante el proceso de evaluación le dieron trato digno y respetuoso?',
            'question4' => '4. ¿Le realizaron la evaluación sin que la ECE/OC/CE/EI lo condicionaran a tomar un curso de capacitación?',
            'question5' => '5. ¿Le presentaron y acordaron con usted el plan de evaluación?',
            'question6' => '6. ¿Recibió retroalimentación de los resultados de su evaluación?',
            'question7' => '7. ¿El evaluador atendió todas sus dudas?',
            'question8' => '8. ¿Le entregaron el certificado de acuerdo al compromiso establecido?',
        ];

        $emojis = [
            '😀' => 'Muy de acuerdo',
            '🙂' => 'De acuerdo',
            '😐' => 'Parcialmente en desacuerdo',
            '☹️' => 'Totalmente en desacuerdo',
        ];

        foreach ($questions as $key => $question) {
            $selectedEmoji = $survey->$key;
            foreach ($emojis as $emoji => $text) {
                if ($selectedEmoji === $emoji) {
                    $templateProcessor->setValue("{$key}_{$emoji}", 'X');
                } else {
                    $templateProcessor->setValue("{$key}_{$emoji}", '');
                }
            }
        }

        // Reemplazar otros campos
        $templateProcessor->setValue('standardName', $survey->estandar->name ?? 'Nombre del estándar no disponible');
        $templateProcessor->setValue('name', $survey->name);
        $templateProcessor->setValue('examDate', \Carbon\Carbon::parse($survey->exam_date)->format('d/m/Y'));
        $templateProcessor->setValue('doubts', $survey->doubts ?: 'Ninguno');

        // Agregar el logo
        if ($survey->logo) {
            $logoPathFull = storage_path('app/public/' . $survey->logo);
            $templateProcessor->setImageValue('logo', $logoPathFull);
        } else {
            $logoPathFull = public_path('assets/img/logo.jpeg');
            $templateProcessor->setImageValue('logo', $logoPathFull);
        }

        // Guardar el documento Word
        $fileName = 'Encuesta_Satisfaccion_' . $survey->name . '.docx';
        $filePath = storage_path('app/public/' . $fileName);
        $templateProcessor->saveAs($filePath);

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
