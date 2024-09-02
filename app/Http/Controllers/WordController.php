<?php

namespace App\Http\Controllers;

use App\Models\CartasDocumentos;
use App\Models\User;
use App\Models\Estandares;
use App\Models\EvidenciasCompetencias;
use App\Models\FichasDocumentos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WordController extends Controller
{
    public function show($id, $tipoDocumento)
    {
        $estandar = Estandares::find($id);
        return view('expedientes.expedientesUser.evidenciasEC.ficha-carta.show', compact('estandar', 'tipoDocumento'));
    }


    /**
     * Handle the ficha_registro upload.
     */
    public function uploadFichaRegistro(Request $request, $id)
    {
        // Validar la solicitud
        $request->validate([
            'ficha_registro' => 'required|file|mimes:pdf|max:2048',
        ]);

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener el estándar (competencia)
        $competencia = Estandares::find($id);

        // Generar el nombre del archivo usando el nombre completo y matrícula del usuario
        $fileName = 'ficha_registro_' .
            Str::slug($user->name) . '_' .
            Str::slug($user->secondName) . '_' .
            Str::slug($user->paternalSurname) . '_' .
            Str::slug($user->maternalSurname) . '_' .
            $user->matricula . '.' .
            $request->file('ficha_registro')->getClientOriginalExtension();

        // Almacenar el archivo en el directorio especificado
        $filePath = $request->file('ficha_registro')->storeAs(
            'public/documents/evidence/competencias/fichas/' .
                $user->matricula . '/' .
                Str::slug($user->name . ' ' . $user->secondName . ' ' . $user->paternalSurname . ' ' . $user->maternalSurname) . '/' .
                Str::slug($competencia->name),
            $fileName
        );

        // Guardar la información en la tabla fichas_documentos
        $ficha = FichasDocumentos::create([
            'nombre' => $fileName,
            'file_path' => $filePath,
            'user_id' => $user->id,
            'estandar_id' => $id,
            'matricula' => $user->matricula,
        ]);

        // Redirigir con un mensaje de éxito
        return redirect()->route('evidenciasEC.index', ['id' => $id, 'name' => Estandares::find($id)->name])
            ->with('success', 'Ficha de Registro subida correctamente');
    }


    /**
     * Handle the carta_firma upload.
     */
    public function uploadCartaFirma(Request $request, $id)
    {
        $request->validate([
            'carta_firma' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener el estándar (competencia)
        $competencia = Estandares::find($id);

        $fileName = 'carta_firma_' .
            Str::slug($user->name) . '_' .
            Str::slug($user->secondName) . '_' .
            Str::slug($user->paternalSurname) . '_' .
            Str::slug($user->maternalSurname) . '_' . // Asegúrate de que el campo esté presente en el modelo User
            $user->matricula . '.' .
            $request->file('carta_firma')->getClientOriginalExtension();


        // Almacenar el archivo en el directorio especificado
        $filePath = $request->file('carta_firma')->storeAs(
            'public/documents/evidence/competencias/carta/' .
                $user->matricula . '/' .
                Str::slug($user->name . ' ' . $user->secondName . ' ' . $user->paternalSurname . ' ' . $user->maternalSurname) . '/' .
                Str::slug($competencia->name),
            $fileName
        );

        // Guardar la información en la tabla fichas_documentos
        $ficha = CartasDocumentos::create([
            'nombre' => $fileName,
            'file_path' => $filePath,
            'user_id' => $user->id,
            'estandar_id' => $id,
            'matricula' => $user->matricula, // Agrega este campo si lo necesitas en la base de datos
        ]);

        return redirect()->route('evidenciasEC.index', ['id' => $id, 'name' => Estandares::find($id)->name])
            ->with('success', 'Carta de Firma subida correctamente');
    }

    public function generateWord($userId, $standardId)
    {
        // Ruta a tu plantilla de documento Word para la ficha de registro
        $templatePath = public_path('templates/ficha_de_Registro_Candidato.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        // Recuperar datos del usuario de la base de datos
        $user = User::findOrFail($userId);

        // Recuperar datos del estándar o competencia específico
        $competencia = Estandares::findOrFail($standardId);

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

        // Reemplazar marcadores de competencia
        $templateProcessor->setValue('competencia_numero', $competencia->numero);
        $templateProcessor->setValue('competencia_name', $competencia->name);

        // Asegurarse de que la carpeta exista
        if (!Storage::exists('public/documents/required/form/toke/')) {
            Storage::makeDirectory('public/documents/required/form/toke/');
        }

        // Crear un nombre de archivo único usando el nombre del usuario y el número de competencia
        $fileName = 'Ficha_de_Registro_' . ' de ' . $user->name . ' ' . $user->secondName . ' ' . $user->paternalSurname . ' ' . $user->maternalSurname . '_' . $user->matricula . '_' . $competencia->numero . '.docx';
        $outputPath = storage_path('app/public/documents/required/form/toke/' . $fileName);
        $templateProcessor->saveAs($outputPath);

        // Descargar el archivo sin eliminarlo después
        return response()->download($outputPath);
    }

    public function generateCarta($userId)
    {
        // Ruta a tu plantilla de documento Word para la carta de autorización
        $templatePath = public_path('templates/Carta_para_la_autorización_de_uso_de_firma_digital.docx');
        $templateProcessor = new TemplateProcessor($templatePath);

        // Recuperar datos del usuario de la base de datos
        $user = User::findOrFail($userId);

        // Reemplazar marcadores en la plantilla
        $templateProcessor->setValue('user_name', $user->name);
        $templateProcessor->setValue('user_secondName', $user->secondName);
        $templateProcessor->setValue('user_paternalSurname', $user->paternalSurname);
        $templateProcessor->setValue('user_maternalSurname', $user->maternalSurname);

        // Asegurarse de que la carpeta exista
        if (!Storage::exists('public/documents/required/form/letter/')) {
            Storage::makeDirectory('public/documents/required/form/letter/');
        }

        // Crear un nombre de archivo único usando el nombre del usuario
        $fileName = 'Carta_para_la_autorización_de_uso_de_firma_digital_' . ' de ' . $user->name . ' ' . $user->secondName . ' ' . $user->paternalSurname . ' ' . $user->maternalSurname . '_' . $user->matricula . '.docx';
        $outputPath = storage_path('app/public/documents/required/form/letter/' . $fileName);
        $templateProcessor->saveAs($outputPath);

        // Descargar el archivo sin eliminarlo después
        return response()->download($outputPath);
    }
}
