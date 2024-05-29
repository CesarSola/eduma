<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Agregamos la importación de la clase Mail
use Illuminate\Http\Response; // Agregamos la importación de la clase Response
use App\Mail\ExampleMail; // Importamos la clase de correo electrónico que definimos anteriormente

class EmailController extends Controller {

    public function enviarEmail() {
        $email = 'correo a enviar';

        $mailData = [
            'title' => 'Titulo',
            'url' => 'https://'
        ];

        Mail::to($email)->send(new ExampleMail($mailData)); // Utilizamos la clase ExampleMail y pasamos los datos del correo

        return response()->json([
            'message' => 'Email enviado'
        ], Response::HTTP_OK);
    }

}
