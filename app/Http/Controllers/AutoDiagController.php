<?php

namespace App\Http\Controllers;

use App\Models\AutoDiag;
use App\Models\Criterio;
use App\Models\Elemento;
use App\Models\Estandares;
use Illuminate\Http\Request;

class AutoDiagController extends Controller
{
    public function index()
    {
        // Obtener autodiagnósticos con la relación estandar
        $autodiagnosticos = AutoDiag::with('estandar')->get();

        // Obtener todos los elementos
        $elementos = Elemento::all();

        // Asegúrate de que el modelo Estandar existe y se importa correctamente
        $estandares = Estandares::all();

        return view('expedientes.autoDiag.index', compact('autodiagnosticos', 'elementos', 'estandares'));
    }

    public function show($id)
    {
        // Cargar el autodiagnóstico
        $diagnostico = AutoDiag::findOrFail($id);

        // Cargar los elementos asociados al autodiagnóstico
        $elementos = Elemento::with(['criterios.preguntas']) // Asegúrate de que la relación se llame 'preguntas'
            ->where('autodiagnostico_id', $id)
            ->get();

        // Retornar la vista con las variables necesarias
        return view('expedientes.autoDiag.show', compact('diagnostico', 'elementos'));
    }



    // Mostrar el formulario de creación
    public function create()
    {
        $estandares = Estandares::all(); // Obtiene todos los estándares
        return view('expedientes.autoDiag.create', compact('estandares'));
    }

    // Almacenar el autodiagnóstico
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'estandar_id' => 'required|exists:estandares,id',
            'elementos' => 'required|integer|min:3|max:5',
            'nombres_elementos' => 'required|array|min:3|max:5',
            'nombres_elementos.*' => 'required|string|max:255',
            'criterios' => 'required|array', // Validación para criterios
            'criterios.*.*' => 'required|string|max:255', // Cada criterio debe ser una cadena de texto
        ]);

        // Crear el autodiagnóstico
        $autoDiag = AutoDiag::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'estandar_id' => $request->estandar_id,
            'elementos' => $request->elementos, // Guardar solo el número de elementos
        ]);

        // Guardar los elementos en la tabla elementos
        foreach ($request->nombres_elementos as $index => $nombre) { // Usar $index para obtener la posición
            $elemento = Elemento::create([
                'autodiagnostico_id' => $autoDiag->id, // Relacionar con el autodiagnóstico
                'nombre' => $nombre, // Guardar el nombre del elemento
            ]);

            // Guardar criterios para cada elemento en la tabla de criterios
            if (isset($request->criterios[$index + 1])) { // Usar $index + 1 para acceder a los criterios
                foreach ($request->criterios[$index + 1] as $criterio) {
                    Criterio::create([
                        'elemento_id' => $elemento->id, // Usa 'elemento_id' para la relación
                        'nombre' => $criterio, // Cambiar 'criterio' por 'nombre'
                    ]);
                }
            }
        }

        return redirect()->route('autodiagnosticos.index')->with('success', 'Autodiagnóstico creado con éxito.');
    }


    public function destroy($id)
    {
        $autoDiag = AutoDiag::findOrFail($id); // Buscar el autodiagnóstico por ID
        $autoDiag->delete(); // Eliminar el autodiagnóstico

        return redirect()->route('autodiagnosticos.index')->with('success', 'Autodiagnóstico eliminado con éxito.');
    }
}
