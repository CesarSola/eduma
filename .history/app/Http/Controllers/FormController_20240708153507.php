<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SurveyResponse;

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

        SurveyResponse::create([
            'name' => $validatedData['name'],
            'question1' => $validatedData['question1'],
            'question2' => $validatedData['question2'],
            'question3' => $validatedData['question3'],
            'question4' => $validatedData['question4'],
            'question5' => $validatedData['question5'],
            'question6' => $validatedData['question6'],
            'question7' => $validatedData['question7'],
            'question8' => $validatedData['question8'],
            'doubts' => $validatedData['doubts'],
        ]);

        return redirect('/form')->with('success', 'Formulario enviado con éxito!');
    }
}
