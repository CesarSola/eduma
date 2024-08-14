@extends('adminlte::page')

@section('title', 'Mis Usuarios')

@section('content_header')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="text-primary">Mis Usuarios</h1>
                    <a href="{{ route('usuariosAdmin.index') }}" class="btn btn-primary">Regresar a Expedientes</a>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        @foreach ($usuarios as $usuario)
            <div class="mb-4">
                @foreach ($usuario->estandares as $estandar)
                    @if (!$loop->first)
                    @break
                @endif
                <a href="{{ route('calendario.show', ['competenciaId' => $estandar->id]) }}" class="btn btn-primary">
                    <i class="fas fa-calendar-alt"></i> Mi calendario
                </a>
            @endforeach
        </div>
    @endforeach

    <!-- Sección de Usuarios -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-lg border-success rounded-lg">
                <div class="card-header bg-success text-white">
                    <h5 class="card-title mb-0">Usuarios Asignados</h5>
                </div>
                <div class="card-body">
                    @if ($usuarios->isEmpty())
                        <div class="alert alert-info" role="alert">
                            No hay usuarios asignados a este evaluador.
                        </div>
                    @else
                        @php
                            // Usamos una colección para almacenar los IDs de usuarios que ya hemos mostrado
                            $usuariosMostrados = collect();
                        @endphp

                        @foreach ($usuarios as $usuario)
                            @if (!$usuariosMostrados->contains($usuario->id))
                                @php
                                    // Agregamos el ID del usuario actual a la colección para evitar mostrarlo nuevamente
                                    $usuariosMostrados->push($usuario->id);
                                @endphp
                                <div class="mb-4">
                                    <div class="row">
                                        <!-- Datos personales del usuario en el lado izquierdo -->
                                        <div class="col-md-5">
                                            <div class="border rounded p-3 bg-light">
                                                <h6 class="text-primary mb-2"><i class="fas fa-user"></i> Datos del
                                                    Usuario:</h6>
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item"><strong>Nombres:</strong>
                                                        {{ $usuario->name }} {{ $usuario->secondName }}</li>
                                                    <li class="list-group-item"><strong>Apellidos:</strong>
                                                        {{ $usuario->paternalSurname }} {{ $usuario->maternalSurname }}
                                                    </li>
                                                    <li class="list-group-item"><strong>Matrícula:</strong>
                                                        {{ $usuario->matricula }}</li>
                                                    <li class="list-group-item"><strong>Email:</strong>
                                                        {{ $usuario->email }}</li>
                                                </ul>
                                            </div>
                                        </div>
                                        <!-- Estándares en el lado derecho -->
                                        <div class="col-md-7">
                                            <div class="border rounded p-3 bg-light">
                                                <h6 class="text-primary mb-2"><i class="fas fa-tasks"></i> Estándares
                                                    Asignados:</h6>
                                                <ul class="list-group">
                                                    @foreach ($usuario->estandares as $estandar)
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <span
                                                                    class="badge badge-info">{{ $estandar->numero }}</span>
                                                                - {{ $estandar->name }}
                                                            </div>
                                                            <div>
                                                                @if ($estandar->fechas->isNotEmpty())
                                                                    <span class="badge badge-success">Fechas y Horarios
                                                                        Asignados</span>
                                                                @else
                                                                    <button class="btn btn-success btn-sm"
                                                                        data-toggle="modal"
                                                                        data-target="#modalAgregarFechas{{ $usuario->id }}-{{ $estandar->id }}">
                                                                        <i class="fas fa-calendar-plus"></i> Agregar
                                                                        Fechas
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="my-4"> <!-- Separador entre usuarios -->
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('expedientes.expedientesAdmin.competencias.fechas.agregar-fechas')
@stop

@section('css')
<style>
    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .card-header {
        border-bottom: 2px solid #238500;
    }

    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    .btn-secondary:hover {
        background-color: #5a6268;
        border-color: #545b62;
    }

    .border {
        border-color: #dee2e6;
    }

    .rounded-lg {
        border-radius: 0.5rem;
    }

    .alert-info {
        border-radius: 0.5rem;
    }

    .btn-success {
        background-color: #28a745;
        border-color: #28a745;
    }

    .btn-success:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }
</style>
@stop

@section('js')

@stop
