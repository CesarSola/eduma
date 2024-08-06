<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CodigoPostal;

use Maatwebsite\Excel\Facades\Excel; // Importa la clase Excel desde su espacio de nombres correcto
use App\Imports\CodigosPostalesImport;
use Illuminate\Support\Facades\Log;

class CodigoPostalController extends Controller
{
    // Método para mostrar todos los registros paginados
    public function index()
    {
        $codigosPostales = CodigoPostal::paginate(60); // Paginar los resultados, mostrando 50 por página
        return view('codigos-postales.index', compact('codigosPostales'));
    }

    // Otros métodos para crear, editar y eliminar registros

    // Método para mostrar el formulario de crear un nuevo registro
    public function create()
    {
        return view('codigos-postales.create');
    }

    // Método para almacenar un nuevo registro en la base de datos
    public function store(Request $request)
    {
        // Validación de los datos del formulario
        $request->validate([
            // Aquí defines las reglas de validación para cada campo
        ]);

        // Crear un nuevo registro en la base de datos
        CodigoPostal::create($request->all());

        return redirect()->route('codigos-postales.index')->with('success', '¡El código postal se ha creado correctamente!');
    }

    // Método para obtener detalles del código postal
    public function obtenerDetallesCodigoPostal(Request $request)
    {
        // Obtener el código postal enviado desde la solicitud
        $codigoPostal = $request->input('codigo_postal');

        // Buscar todas las colonias con el mismo código postal en la base de datos
        $codigosPostales = CodigoPostal::where('d_codigo', $codigoPostal)->get();

        // Verificar si se encontraron colonias
        if ($codigosPostales->isEmpty()) {
            // Si no se encuentran colonias, devolver un mensaje de error
            return response()->json([
                'error' => 'No se encontraron colonias para el código postal proporcionado.'
            ], 404); // 404 indica que no se encontraron las colonias
        } else {
            // Devolver los detalles de los códigos postales en formato JSON
            return response()->json([
                'codigosPostales' => $codigosPostales
            ]);
        }
    }
    public function importarExcel(Request $request)
    {
        $request->validate([
            'archivo_excel' => 'required|mimes:xlsx,xls',
        ]);

        $archivo = $request->file('archivo_excel');

        try {
            Excel::import(new CodigosPostalesImport, $archivo);
        } catch (\Exception $e) {
            Log::error('Error durante la importación:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['msg' => 'Ocurrió un error durante la importación. Verifica el archivo y vuelve a intentarlo.']);
        }

        return redirect()->back()->with('success', '¡Los datos se han importado correctamente!');
    }
}