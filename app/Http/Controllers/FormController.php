<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveyResponse;
use App\Models\Estandares;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    public function showForm($estandar_id)
    {
        $estandar = Estandares::findOrFail($estandar_id);
        $standardName = $estandar->name;

        return view('encuestasatisfaccion.index', compact('standardName', 'estandar_id'));
    }

    public function submitForm(Request $request, $estandar_id)
    {
        // Validar los datos
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'exam_date' => 'required|date',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048',
            'question1' => 'required',
            'question2' => 'required',
            'question3' => 'required',
            'question4' => 'required',
            'question5' => 'required',
            'question6' => 'required',
            'question7' => 'required',
            'question8' => 'required',
            'doubts' => 'nullable|string',
        ]);
    
        $estandar = Estandares::findOrFail($estandar_id);
    
        // Verificar si el usuario ya ha respondido la encuesta para este estándar
        $existingResponse = SurveyResponse::where('user_id', Auth::id())
                                         ->where('estandar_id', $estandar_id)
                                         ->first();
    
        if ($existingResponse) {
            return redirect()->route('form.submit', ['estandar_id' => $estandar_id])
                             ->with('error', 'Ya has respondido esta encuesta');
        }
    
        // Subir el logo si se proporciona
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }
    
        // Guardar los datos de la encuesta en la base de datos
        $surveyResponse = SurveyResponse::create([
            'name' => $validatedData['name'],
            'exam_date' => $validatedData['exam_date'],
            'logo' => $logoPath,
            'question1' => $validatedData['question1'],
            'question2' => $validatedData['question2'],
            'question3' => $validatedData['question3'],
            'question4' => $validatedData['question4'],
            'question5' => $validatedData['question5'],
            'question6' => $validatedData['question6'],
            'question7' => $validatedData['question7'],
            'question8' => $validatedData['question8'],
            'doubts' => $validatedData['doubts'],
            'user_id' => Auth::id(), // Asegúrate de que el usuario esté autenticado
            'estandar_id' => $estandar_id, // Incluye estandar_id aquí
        ]);
    
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
            $selectedEmoji = $validatedData[$key];
            foreach ($emojis as $emoji => $text) {
                if ($selectedEmoji === $emoji) {
                    $templateProcessor->setValue("{$key}_{$emoji}", 'X');
                } else {
                    $templateProcessor->setValue("{$key}_{$emoji}", '');
                }
            }
        }
    
        // Reemplazar otros campos
        $templateProcessor->setValue('standardName', $estandar->name);
        $templateProcessor->setValue('name', $validatedData['name']);
        $templateProcessor->setValue('examDate', \Carbon\Carbon::parse($validatedData['exam_date'])->format('d/m/Y'));
        $templateProcessor->setValue('doubts', $validatedData['doubts'] ?: 'Ninguno');
    
        // Agregar el logo
        if ($logoPath) {
            $logoPathFull = storage_path('app/public/' . $logoPath);
            $templateProcessor->setImageValue('logo', $logoPathFull);
        } else {
            $logoPathFull = public_path('assets/img/logo.jpeg');
            $templateProcessor->setImageValue('logo', $logoPathFull);
        }
    
        // Guardar el documento Word
        $fileName = 'Encuesta_Satisfaccion_' . $validatedData['name'] . '.docx';
        $filePath = storage_path('app/public/' . $fileName);
        $templateProcessor->saveAs($filePath);
    
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
    
}
