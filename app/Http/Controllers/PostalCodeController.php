<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostalCodeController extends Controller
{
    public function index(Request $request)
    {
        $codigoPostal = $request->input('codigo_postal');
        $response = Http::get("https://api.copomex.com/query/get_colonia_por_cp/{$codigoPostal}?token=1a1e01a4-11bd-4a5d-a9b5-fe563db704ea");
        $data = $response->json();

        return response()->json($data['response']['colonia']);
    }

}
