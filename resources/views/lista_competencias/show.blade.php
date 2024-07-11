@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <strong>{{ $competencias->numero }} </strong>{{ $competencias->name }}
        </h1>
    </div>
    <br>
    <h3>
        Requisitos para la evaluación y certificación
        <button type="button" class="btn btn-success ml-2">
            Descargar
        </button>
    </h3>
    <br>

@stop

@section('content')
    <h4 class="pl-4">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna
        aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur
        sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </h4>
    <hr>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Lista de Documentos</h2>
        <ul class="list-disc list-inside bg-white p-4 rounded-lg shadow-md dark:bg-gray-800">
            <li class="mb-2 text-gray-900 dark:text-white">
                <a href="URL_TO_PDF" class="text-blue-500 hover:underline dark:text-blue-300">CARTA DE AUTORIZACIÓN DE FIRMA
                    DIGITAL PDF</a>
            </li>
            <li class="mb-2 text-gray-900 dark:text-white">
                <a href="URL_TO_PDF" class="text-blue-500 hover:underline dark:text-blue-300">Derechos y obligaciones
                    PDF</a>
            </li>
            <li class="mb-2 text-gray-900 dark:text-white">1. Ficha de registro del candidato</li>
            <li class="mb-2 text-gray-900 dark:text-white">2. Exámen diagnóstico</li>
            <li class="mb-2 text-gray-900 dark:text-white">3. Plan de Evaluación</li>
            <li class="mb-2 text-gray-900 dark:text-white">4. Instrumentos de evaluación: cuestionario, lista de cotejo y
                guías de obervación</li>
            <li class="mb-2 text-gray-900 dark:text-white">5. Juicio de competencia</li>
            <li class="mb-2 text-gray-900 dark:text-white">6. Anexos documentales</li>
            <li class="mb-2 text-gray-900 dark:text-white">7. Cédula de evaluación</li>
            <li class="mb-2 text-gray-900 dark:text-white">8. Encuesta de satisfacción del candidato</li>
        </ul>
    </div>
    <div class="container mx-auto px-4 py-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">Evidencias por estandar</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($competencias->documentosnec as $documento)
                <div class="bg-white shadow-md rounded-lg overflow-hidden dark:bg-gray-800 p-2 mb-4">
                    <div class="p-2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $documento->name }}</h3>
                        <p class="text-gray-700 dark:text-gray-300 text-sm">{{ $documento->description }}</p>
                    </div>
                    <!-- Botón de descarga -->
                    <a href="" download="{{ $documento->documentos }}" class="btn btn-primary">
                        Descargar
                    </a>
                </div>
            @endforeach
        </div>
    </div>


@endsection

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        /* Estilos para los botones y tabla */
        .btn {
            padding: 8px 12px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            border-radius: 5px;
            margin-right: 10px;
        }

        .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
        }

        .small-table {
            width: auto;
            font-size: 12px;
        }

        .small-table th,
        .small-table td {
            padding: 4px 8px;
        }

        .small-table .btn-sm {
            padding: 4px 8px;
            font-size: 12px;
        }
    </style>
@stop
