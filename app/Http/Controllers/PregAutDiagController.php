<?php

namespace App\Http\Controllers;

use App\Models\PregAutDiag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PregAutDiagController extends Controller
{
    public function store(Request $request)
    {
        // Validación
        $request->validate([
            'titulo' => 'required|string|max:255',
            'pregunta' => 'required|array',
            'pregunta.*' => 'required|string|max:255',
            'resp_correcta' => 'required|array',
            'resp_correcta.*' => 'required|in:SI,NO',
            'elemento_id' => 'required|exists:elementos,id',
            'criterio_id' => 'nullable|exists:criterios,id',
            'autodiagnostico_id' => 'required|exists:autodiagnosticos,id',
        ]);

        // Iterar sobre las preguntas y guardarlas individualmente
        foreach ($request->pregunta as $index => $pregunta) {
            PregAutDiag::create([
                'titulo' => $request->titulo,
                'pregunta' => $pregunta,
                'resp_correcta' => $request->resp_correcta[$index],
                'autodiagnostico_id' => $request->autodiagnostico_id, // Asegúrate de que este ID se esté enviando
                'elemento_id' => $request->elemento_id,
                'criterio_id' => $request->criterio_id,
            ]);
        }

        return redirect()->route('autodiagnosticos.show', $request->autodiagnostico_id)
            ->with('success', 'Preguntas creadas con éxito.');
    }
    public function edit($id)
    {
        $pregunta = PregAutDiag::findOrFail($id);
        return response()->json($pregunta);
    }

    public function update(Request $request, $id)
    {
        // Validación
        $request->validate([
            'titulo' => 'required|string|max:255',
            'pregunta' => 'required|string|max:255',
            'resp_correcta' => 'required|in:SI,NO',
            'elemento_id' => 'required|exists:elementos,id',
            'criterio_id' => 'nullable|exists:criterios,id',
            'autodiagnostico_id' => 'required|exists:autodiagnosticos,id',
        ]);

        // Encontrar la pregunta y actualizarla
        $pregunta = PregAutDiag::findOrFail($id);
        $pregunta->update([
            'titulo' => $request->titulo,
            'pregunta' => $request->pregunta,
            'resp_correcta' => $request->resp_correcta,
            'elemento_id' => $request->elemento_id,
            'criterio_id' => $request->criterio_id,
            'autodiagnostico_id' => $request->autodiagnostico_id,
        ]);

        return redirect()->route('autodiagnosticos.show', $request->autodiagnostico_id)
            ->with('success', 'Pregunta actualizada con éxito.');
    }
}
