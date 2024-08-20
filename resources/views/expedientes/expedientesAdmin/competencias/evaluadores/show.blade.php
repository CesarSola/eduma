@extends('adminlte::page')

@section('title', 'Evaluador')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Detalles del Evaluador</h1>
        <a href="{{ route('evaluadores.index') }}" class="btn btn-secondary">
            Regresar
        </a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <!-- Detalles del Evaluador -->
            <div class="col-md-6">
                <div class="card border-primary mb-4 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Detalles del Evaluador</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="me-3">
                                <img src="{{ $evaluador->foto }}" alt="Profile Picture" class="rounded-circle"
                                    width="60" height="60"
                                    onerror="this.src='{{ asset('assets/profile-default/profile_default.jpeg') }}';">
                            </div>
                            <div>
                                <h6 class="font-weight-bold mb-0">{{ $evaluador->name }} {{ $evaluador->secondName }}</h6>
                                <small>{{ $evaluador->paternalSurname }} {{ $evaluador->maternalSurname }}</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <h6 class="font-weight-bold">Correo Electrónico:</h6>
                            <p class="mb-1">{{ $evaluador->email }}</p>
                        </div>
                        <!-- Agrega más detalles según lo necesites -->
                    </div>
                </div>
            </div>

            <!-- Usuarios Asignados -->
            <div class="col-md-6">
                <div class="card border-success mb-4 shadow-sm">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Usuarios Asignados</h5>
                    </div>
                    <div class="card-body">
                        @if ($usuariosAsignados->isEmpty())
                            <p>No hay usuarios asignados a este evaluador.</p>
                        @else
                            <ul class="list-group">
                                @foreach ($usuariosAsignados as $usuario)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-1"><strong>Nombres:</strong> {{ $usuario->name }}
                                                    {{ $usuario->secondName }}</p>
                                                <p class="mb-1"><strong>Apellidos:</strong>
                                                    {{ $usuario->paternalSurname }} {{ $usuario->maternalSurname }}</p>
                                                <p class="mb-1"><strong>Matrícula:</strong> {{ $usuario->matricula }}</p>
                                                <p class="mb-0"><strong>Email:</strong> {{ $usuario->email }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
