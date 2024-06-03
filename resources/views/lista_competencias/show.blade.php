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
    <table id="cursos-table" class="table table-bordered table-hover text-center">
        <thead>
            <tr>
                <td>Nombre</td>
                <td>Acción</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($documentos as $documento)
                <tr>
                    <td>{{ $documento->nombre }}</td>
                    <td>
                        <button class="btn btn-primary">Ver</button>
                        <button class="btn btn-danger">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        /* Estilos para los botones */
        .btn {
            padding: 8px 12px; /* Ajustamos el padding para que los botones sean más compactos */
            border: none;
            cursor: pointer;
            font-size: 14px; /* Reducimos el tamaño de la fuente */
            border-radius: 5px;
            margin-right: 10px;
        }

        /* Ajustamos el espacio entre los elementos */
        .toolbar {
            display: flex;
            align-items: center;
            margin-top: 20px; /* Añadimos un margen superior para separar el contenido anterior */
        }

        .toolbar input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 10px;
        }

        /* Estilos para el cuadrado */
        .square {
            width: 40px; /* Reducimos el tamaño del cuadrado */
            height: 40px; /* Reducimos el tamaño del cuadrado */
            border: 1px dashed black;
            position: relative;
            line-height: 40px;
        }

        .cross {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 18px; /* Ajustamos el tamaño del símbolo "+" */
        }
    </style>
@stop

@section('js')
@stop
