@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded" style="width: 300px;">
            <h1 style="font-size: 1.5rem; margin-bottom: 0;">Mis Competencias</h1>
        </div>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div class="col-md-12 mb-8">
        <div class="card">
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
                <div class="alert alert-primary" role="alert">
                    No tienes cursos inscritos.
                    <a class="btn btn-primary" href="{{ route('competenciaEC.index') }}">Ir a la pestaña de inscripción a un
                        curso</a>
                </div>
            @else
                <ul class="list-group">
                    @foreach ($competencias as $competencia)
                        @php
                            $validacionComentario = $competencia
                                ->validacionesComentarios()
                                ->where('tipo_documento', 'comprobante_pago')
                                ->first();
                            if ($validacionComentario) {
                                $estado = $validacionComentario->tipo_validacion;
                            } else {
                                $estado = null;
                            }
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span style="font-weight: bold; color: #333;">{{ $competencia->name }}</span> -
                                {{ $competencia->tipo }}
                                @if ($estado == 'validar')
                                    <a href="{{ route('evidenciasEC.index', ['id' => $competencia->id, 'name' => $competencia->name]) }}"
                                        class="btn btn-primary btn-sm ml-2">Ver</a>
                                @elseif ($estado == 'rechazar')
                                    <a href="{{ route('miscompetencias.resubir_comprobante', ['id' => $competencia->id]) }}"
                                        class="btn btn-danger btn-sm ml-2">
                                        Resubir Comprobante
                                    </a>
                                @else
                                    <span class="badge badge-warning">En validación</span>
                                @endif
                            </div>
                            @if ($estado == 'validar')
                                <span class="badge badge-success badge-pill">Inscrito</span>
                            @elseif ($estado == 'rechazar')
                                <span class="badge badge-danger badge-pill">Comprobante: Rechazado</span>
                            @else
                                <span class="badge badge-warning badge-pill">Comprobante: Subido</span>
                            @endif
                        </li>
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
