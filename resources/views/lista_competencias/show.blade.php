@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>
            <strong>{{ $competencias->numero }}  </strong>{{ $competencias->name }}
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
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </h4>
    <hr>
        @foreach ($competencias->documentosnec as $documento)
    {{ $documento->name }}<br>
@endforeach



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
