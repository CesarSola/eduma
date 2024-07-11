<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Estandares;
use App\Models\EvidenciasCompetencias;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;
use Illuminate\Support\Facades\Storage;

class WordController extends Controller
{
    public function uploadFicha(Request $request, $userId, $standardId)
    {
        $request->validate([
            'ficha_registro' => 'required|file|mimes:doc,docx|max:2048',
        ]);

        // Guardar el archivo de ficha de registro
        $filePath = $request->file('ficha_registro')->store('public/documents/fichas');

        // Guardar en la tabla evidencias_comentarios
        $evidencia = new EvidenciasCompetencias();
        $evidencia->user_id = $userId;
        $evidencia->estandar_id = $standardId;
        $evidencia->ficha_registro_path = $filePath;
        $evidencia->save();

        return redirect()->back()->with('success', 'Ficha de registro subida correctamente.');
    }

    public function uploadCarta(Request $request, $userId)
    {
        $request->validate([
            'carta_firma' => 'required|file|mimes:doc,docx|max:2048',
        ]);

        // Guardar el archivo de carta de autorización
        $filePath = $request->file('carta_firma')->store('public/documents/cartas');

        // Guardar en la tabla evidencias_comentarios
        $evidencia = new EvidenciasCompetencias();
        $evidencia->user_id = $userId;
        $evidencia->carta_firma_path = $filePath;
        $evidencia->save();

        return redirect()->back()->with('success', 'Carta de autorización subida correctamente.');
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
        if (!Storage::exists('public/documents/required/form/')) {
            Storage::makeDirectory('public/documents/required/form/');
        }

        // Crear un nombre de archivo único usando el nombre del usuario y el número de competencia
        $fileName = 'Ficha_de_Registro_' . $user->name . '_' . $competencia->numero . '.docx';
        $outputPath = storage_path('app/public/documents/required/form/' . $fileName);
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
        if (!Storage::exists('public/documents/required/form/')) {
            Storage::makeDirectory('public/documents/required/form/');
        }

        // Crear un nombre de archivo único usando el nombre del usuario
        $fileName = 'Carta_para_la_autorización_de_uso_de_firma_digital_' . $user->name . '.docx';
        $outputPath = storage_path('app/public/documents/required/form/' . $fileName);
        $templateProcessor->saveAs($outputPath);

        // Descargar el archivo sin eliminarlo después
        return response()->download($outputPath);
    }
}
