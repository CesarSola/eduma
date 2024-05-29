<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ColoniaController extends Controller
{
    public function buscarColonia(Request $request)
    {
        $codigoPostal = $request->codigo_postal;
        $token = 'TU_TOKEN_COPOMEX'; // Reemplaza esto con tu token real

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $token
        ])->get('https://api.copomex.com/query/info_cp/' . $codigoPostal . '?type=simplified');

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'No se pudo obtener la información'], 400);
        }
    }
}
