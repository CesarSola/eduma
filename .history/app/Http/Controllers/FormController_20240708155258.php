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

        // Generate Word Document
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Title
        $section->addTitle('Encuesta de Satisfacción', 1);

        // Datos del formulario
        $section->addText('Nombre: ' . $request->input('name'));
        $section->addText('Respuestas:');

        foreach(range(1, 8) as $index) {
            $question = $request->input('question'.$index);
            $section->addText('Pregunta '.$index.': '.$question);
        }

        // Otros comentarios
        $doubts = $request->input('doubts');
        $section->addText('Otros comentarios: '.$doubts);

        // Save document
        $fileName = 'encuesta_satisfaccion_' . date('YmdHis') . '.docx';
        $filePath = storage_path('app/public/' . $fileName);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filePath);

        // Descargar documento
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function downloadEmptyForm()
    {
        // Generate Word Document with empty form
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

        // Title
        $section->addTitle('Encuesta de Satisfacción', 1);

        // Save document
        $fileName = 'encuesta_satisfaccion_vacia_' . date('YmdHis') . '.docx';
        $filePath = storage_path('app/public/' . $fileName);
        $objWriter = IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($filePath);

        // Descargar documento
        return response()->download($filePath)->deleteFileAfterSend(true);
    }
}
