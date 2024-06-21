@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded">
            <h1>Mis Competencias</h1>
        </div>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div class="col-md-12 mb-8">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="card-title mb-0">
                    Competencias inscritas por {{ $usuario->name }}
                </h6>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="container">
            @if ($competencias->isEmpty())
                <p>No tienes competencias inscritas.</p>
            @else
                <ul>
                    @foreach ($competencias as $competencia)
                        <li>{{ $competencia->name }} - {{ $competencia->tipo }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Estilos personalizados aquí */
    </style>
@stop

@section('js')
    <script>
        console.log("Hola, estoy usando el paquete Laravel-AdminLTE!");
    </script>
@stop
