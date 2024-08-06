<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AtencionUsuario;
use App\Models\Estandares;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Log;

class AtencionUsuariosController extends Controller
{
    public function create($estandar_id)
    {
        $estandar = Estandares::findOrFail($estandar_id);
        return view('atencion_usuarios.index', [
            'estandar_id' => $estandar_id,
            'estandar_nombre' => $estandar->name,
        ]);
    }

    public function store(Request $request, $estandar_id)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            // Otros campos de validación aquí...
            'año' => 'required|string',
            'presencial' => 'nullable|string',
            'celular' => 'nullable|string',
            'correo' => 'nullable|string',
            'medio_contacto' => 'nullable|string',
            'lugar' => 'required|string',
            'fecha' => 'required|date',
            'nombre' => 'required|string',
            'apellidos' => 'required|string',
            'domicilio' => 'required|string',
            'colonia' => 'required|string',
            'codigo_postal' => 'required|string',
            'delegacion' => 'required|string',
            'estado' => 'required|string',
            'ciudad' => 'required|string',
            'fax' => 'nullable|string',
            'telefono' => 'required|string',
            'email' => 'required|email',
            'calificacion_atencion' => 'required|string',
            'tiempo_atencion' => 'required|string',
            'trato_amable' => 'required|string',
            'confianza_atencion' => 'required|string',
            'comprension_atencion' => 'required|string',
        ]);

        // Obtener el nombre del estándar y el usuario
        $estandar = Estandares::find($estandar_id);
        $user = Auth::user();

        // Agregar el nombre del estándar, el usuario y el estandar_id a los datos
        $validatedData['estandar_id'] = $estandar_id;
        $validatedData['user_id'] = $user->id;

        // Guardar en la base de datos
        try {
            AtencionUsuario::create($validatedData);
            Log::info('Datos guardados:', $validatedData);
        } catch (\Exception $e) {
            Log::error('Error al guardar los datos:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error al guardar los datos: ' . $e->getMessage());
        }

        // Redirigir a la ruta para generar el documento
        return redirect()->route('formato-atencion.download', ['estandar_id' => $estandar_id]);
    }

    public function download($estandar_id)
    {
        // Obtener el último registro de atención del usuario para el estándar específico
        $atencion = AtencionUsuario::where('estandar_id', $estandar_id)
            ->where('user_id', Auth::id())
            ->latest()
            ->first();
        
        if (!$atencion) {
            Log::error('No se encontraron datos para el documento.', ['estandar_id' => $estandar_id]);
            return redirect()->back()->with('error', 'No se encontraron datos para generar el documento.');
        }
    
        // Cargar la plantilla
        $templatePath = storage_path('app/public/Atencion_Usuarios.docx');
        if (!file_exists($templatePath)) {
            Log::error('La plantilla de documento no se encontró.', ['templatePath' => $templatePath]);
            return redirect()->back()->with('error', 'La plantilla de documento no se encontró en la ruta especificada.');
        }
        
        $templateProcessor = new TemplateProcessor($templatePath);
    
        // Reemplazar los marcadores de posición con los datos del formulario
        $templateProcessor->setValue('año', $atencion->año);
        $templateProcessor->setValue('presencial', $atencion->presencial);
        $templateProcessor->setValue('celular', $atencion->celular);
        $templateProcessor->setValue('correo', $atencion->correo);
        $templateProcessor->setValue('medio_contacto', $atencion->medio_contacto);
        $templateProcessor->setValue('lugar', $atencion->lugar);
        $templateProcessor->setValue('fecha', $atencion->fecha->format('d/m/Y'));
        $templateProcessor->setValue('nombre', $atencion->nombre);
        $templateProcessor->setValue('apellidos', $atencion->apellidos);
        $templateProcessor->setValue('domicilio', $atencion->domicilio);
        $templateProcessor->setValue('colonia', $atencion->colonia);
        $templateProcessor->setValue('codigo_postal', $atencion->codigo_postal);
        $templateProcessor->setValue('delegacion', $atencion->delegacion);
        $templateProcessor->setValue('estado', $atencion->estado);
        $templateProcessor->setValue('ciudad', $atencion->ciudad);
        $templateProcessor->setValue('fax', $atencion->fax);
        $templateProcessor->setValue('telefono', $atencion->telefono);
        $templateProcessor->setValue('email', $atencion->email);
    
        // Opciones de respuesta
        $options = ['Bueno', 'Regular', 'Malo'];
    
        // Función para reemplazar marcadores según la respuesta
        function setOption($templateProcessor, $question, $response, $options) {
            foreach ($options as $option) {
                $templateProcessor->setValue($question . '_' . $option, $response === $option ? 'X' : '');
            }
        }
    
        // Reemplazar los marcadores de posición con las respuestas del formulario
        setOption($templateProcessor, 'calificacion_atencion', $atencion->calificacion_atencion, $options);
        setOption($templateProcessor, 'tiempo_atencion', $atencion->tiempo_atencion, $options);
        setOption($templateProcessor, 'trato_amable', $atencion->trato_amable, $options);
        setOption($templateProcessor, 'confianza_atencion', $atencion->confianza_atencion, $options);
        setOption($templateProcessor, 'comprension_atencion', $atencion->comprension_atencion, $options);
    
        // Generar un nombre único para el archivo
        $fileName = 'formato_atencion_' . time() . '.docx';
        $filePath = storage_path('app/public/' . $fileName);
        try {
            // Guardar el documento Word modificado
            $templateProcessor->saveAs($filePath);
            Log::info('Documento guardado:', ['filePath' => $filePath]);
        } catch (\Exception $e) {
            Log::error('Error al guardar el documento:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Error al guardar el documento: ' . $e->getMessage());
        }
    
        // Descargar el archivo Word
        if (file_exists($filePath)) {
            return response()->download($filePath)->deleteFileAfterSend(true);
        } else {
            Log::error('El archivo no pudo ser encontrado para descarga.', ['filePath' => $filePath]);
            return redirect()->back()->with('error', 'El archivo no pudo ser encontrado para descarga.');
        }
    }
    
    public function downloadFile($id)
    {
        $atencionUsuario = AtencionUsuario::findOrFail($id);

        $filePath = storage_path('app/public/' . $atencionUsuario->document_path);

        if (file_exists($filePath)) {
            return response()->download($filePath)->deleteFileAfterSend(true);
        } else {
            return redirect()->back()->with('error', 'El archivo no existe.');
        }
    }
    
}
