<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

class FormController extends Controller
{
    public function showForm()
    {
        return view('encuestasatisfaccion.index');
    }

    public function submitForm(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
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

        // Generar documento Word con respuestas
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Título
        $section->addTitle('Encuesta de Satisfacción', 1);

        // Datos del formulario
        $section->addText('Nombre: ' . $request->input('name'));
        $section->addText('Respuestas:');

        foreach (range(1, 8) as $index) {
            $question = $request->input('question' . $index);
            $emoji = '';
            switch ($question) {
                case '😀':
                    $emoji = 'Muy de acuerdo';
                    break;
                case '🙂':
                    $emoji = 'De acuerdo';
                    break;
                case '😐':
                    $emoji = 'Parcialmente en desacuerdo';
                    break;
                case '☹️':
                    $emoji = 'Totalmente en desacuerdo';
                    break;
                default:
                    $emoji = 'Sin respuesta';
                    break;
            }
            $section->addText('Pregunta ' . $index . ': ' . $emoji);
        }

        // Otros comentarios
        $doubts = $request->input('doubts');
        $section->addText('Otros comentarios: ' . $doubts);

        // Guardar documento
        $fileName = 'encuesta_satisfaccion_' . date('YmdHis') . '.docx';
        $filePath = storage_path('app/public/' . $fileName);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filePath);

        // Descargar documento
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function downloadEmptyForm()
    {
        // Generar documento Word vacío
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Título
        $section->addTitle('Encuesta de Satisfacción', 1);

        // Agregar contenido adicional (opcional)
        $section->addText('Preguntas:');
        $section->addText('1. ¿La presentación del estándar de competencia y la aplicación del diagnóstico, lo realizaron sin costo para usted?');
        $section->addText('2. ¿Le proporcionaron la información suficiente y necesaria para iniciar su proceso de evaluación?');
        $section->addText('3. ¿Durante el proceso de evaluación le dieron trato digno y respetuoso?');
        $section->addText('4. ¿Le realizaron la evaluación sin que la ECE/OC/CE/EI lo condicionaran a tomar un curso de capacitación?');
        $section->addText('5. ¿Le presentaron y acordaron con usted el plan de evaluación?');
        $section->addText('6. ¿Recibió retroalimentación de los resultados de su evaluación?');
        $section->addText('7. ¿El evaluador atendió todas sus dudas?');
        $section->addText('8. ¿Le entregaron el certificado de acuerdo al compromiso establecido?');
        $section->addText('Otros comentarios:');

        // Guardar documento
        $fileName = 'encuesta_satisfaccion_vacia_' . date('YmdHis') . '.docx';
        $filePath = storage_path('app/public/' . $fileName);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filePath);

        // Descargar documento
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
