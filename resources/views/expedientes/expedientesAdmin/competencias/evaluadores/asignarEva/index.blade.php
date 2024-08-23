@extends('adminlte::page')

@section('title', 'Asignar Evaluadores')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Asignar Evaluadores a Usuarios</h1>
    </div>
@stop

@section('content')
    <div class="container mt-4">
        @if (session('success'))
            <div class="alert alert-success" id="success-message" style="display:none;">
                {{ session('success') }}
            </div>
        @endif
        <div class="row">
            <!-- Sección de Usuarios -->
            <div class="col-12 mb-4">
                <div class="card h-100 shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Usuarios</h5> <!-- Título general -->
                    </div>
                    <div class="card-body">
                        @foreach ($users as $user)
                            <div class="mb-4">
                                <div class="row">
                                    <!-- Datos personales del usuario en el lado izquierdo -->
                                    <div class="col-md-5">
                                        <h6 class="text-primary"><i class="fas fa-user"></i> Datos del Usuario:</h6>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item"><strong>Nombre:</strong> {{ $user->name }}
                                                {{ $user->secondName }} {{ $user->paternalSurname }}
                                                {{ $user->maternalSurname }}</li>
                                            <li class="list-group-item"><strong>Matrícula:</strong> {{ $user->matricula }}
                                            </li>
                                            <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                                        </ul>
                                    </div>
                                    <!-- Estándares en el lado derecho -->
                                    <div class="col-md-7">
                                        <h6 class="text-primary"><i class="fas fa-tasks"></i> Estándares Asignados:</h6>
                                        <ul class="list-group">
                                            @foreach ($user->estandares as $estandar)
                                                <li
                                                    class="list-group-item d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <span class="badge badge-info">{{ $estandar->numero }}</span> -
                                                        {{ $estandar->name }}
                                                    </div>
                                                    <div>
                                                        @if (isset($evaluacionesPorUsuario[$user->id][$estandar->id]))
                                                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                                                <i class="fas fa-check-circle"></i> Evaluador Asignado
                                                            </button>
                                                        @else
                                                            <button class="btn btn-outline-primary btn-sm"
                                                                data-toggle="modal"
                                                                data-target="#asignarEvaluadorModal{{ $user->id }}-{{ $estandar->id }}">
                                                                <i class="fas fa-user-plus"></i> Asignar Evaluador
                                                            </button>
                                                        @endif
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <hr> <!-- Separador entre usuarios -->
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Fila para "Usuarios con sus evaluadores" -->
            <div class="col-md-6">
                <!-- Sección para mostrar usuarios con evaluaciones -->
                <div class="card h-100 border-primary mb-4 shadow-lg d-flex flex-column">
                    <div class="card-header bg-primary text-white">
                        <h5 class="card-title mb-0">Usuarios con sus Evaluadores</h5>
                    </div>
                    <div class="card-body flex-fill scrollable-card-body">
                        @forelse ($usuariosConEvaluaciones as $usuarioId => $evaluaciones)
                            @php
                                $usuario = $evaluaciones->first()->usuario;
                            @endphp
                            <div class="mb-4 p-4 border rounded bg-white shadow-sm">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle overflow-hidden mr-3" style="width: 60px; height: 60px;">
                                        <img src="{{ $usuario->foto }}" alt="Profile Picture"
                                            class="img-fluid rounded-circle" width="60" height="60"
                                            onerror="this.src='{{ asset('assets/profile-default/profile_default.jpeg') }}';">
                                    </div>
                                    <div>
                                        <h6 class="font-weight-bold mb-0 text-secondary">Nombre del Usuario:</h6>
                                        <p class="mb-0 text-dark">{{ $usuario->name }}
                                            {{ $usuario->secondName }}
                                            {{ $usuario->paternalSurname }}
                                            {{ $usuario->maternalSurname }}</p>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center mb-3">
                                    <div class="icon bg-success text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-id-badge" style="font-size: 24px;"></i>
                                    </div>
                                    <div>
                                        <h6 class="font-weight-bold mb-0 text-secondary">Matrícula:</h6>
                                        <p class="mb-0 text-dark">{{ $usuario->matricula }}</p>
                                    </div>
                                </div>

                                <!-- Itera sobre los estándares evaluados por este usuario -->
                                @foreach ($evaluaciones->groupBy('estandar_id') as $estandarId => $evaluacionesPorEstandar)
                                    @php
                                        $estandar = $evaluacionesPorEstandar->first()->estandar;
                                    @endphp
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="icon bg-info text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                            style="width: 50px; height: 50px;">
                                            <i class="fas fa-book" style="font-size: 24px;"></i>
                                        </div>
                                        <div>
                                            <h6 class="font-weight-bold mb-0 text-secondary">Estándar:</h6>
                                            <p class="mb-0 text-dark">{{ $estandar->numero }} {{ $estandar->name }}</p>
                                        </div>
                                    </div>

                                    <h6 class="font-weight-bold mt-4 text-secondary">Evaluadores:</h6>
                                    <ul class="list-unstyled">
                                        @foreach ($evaluacionesPorEstandar as $evaluacion)
                                            <li class="mb-3 p-3 border rounded bg-light shadow-sm">
                                                <div class="d-flex align-items-center">
                                                    <div class="icon bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center mr-3"
                                                        style="width: 50px; height: 50px;">
                                                        <i class="fas fa-user-check" style="font-size: 24px;"></i>
                                                    </div>
                                                    <div>
                                                        <p class="mb-0 text-dark">{{ $evaluacion->evaluador->name }}
                                                            {{ $evaluacion->evaluador->secondName }}
                                                            {{ $evaluacion->evaluador->paternalSurname }}
                                                            {{ $evaluacion->evaluador->maternalSurname }}</p>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>
                        @empty
                            <p class="text-center text-muted">No hay usuarios asignados.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Fila para "Evaluadores" -->
            <div class="col-md-6">
                <!-- Sección para mostrar evaluadores -->
                <div class="card h-100 border-success mb-4 shadow-lg">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">Evaluadores</h5>
                    </div>
                    <div class="card-body">
                        @foreach ($evaluadores as $evaluador)
                            <div class="mb-4 p-4 border rounded bg-white shadow-sm">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="me-3 rounded-circle overflow-hidden" style="width: 60px; height: 60px;">
                                        <img src="{{ $evaluador->foto }}" alt="Profile Picture"
                                            class="img-fluid rounded-circle" width="60" height="60"
                                            onerror="this.src='{{ asset('assets/profile-default/profile_default.jpeg') }}';">
                                    </div>
                                    <div>
                                        <h6 class="font-weight-bold mb-1 text-secondary">Nombre del Evaluador:</h6>
                                        <p class="mb-0 text-dark">{{ $evaluador->name }} {{ $evaluador->paternalSurname }}
                                        </p>
                                    </div>
                                </div>
                                <h6 class="font-weight-bold mb-2 text-secondary">Usuarios Asignados:</h6>
                                <ul class="list-unstyled">
                                    @forelse ($usuariosAsignados[$evaluador->id] ?? [] as $evaluacion)
                                        <li class="mb-3 p-3 border rounded bg-light shadow-sm">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <span class="font-weight-bold text-dark">
                                                        {{ $evaluacion->usuario->name }}
                                                        {{ $evaluacion->usuario->secondName }}
                                                        {{ $evaluacion->usuario->paternalSurname }}
                                                        {{ $evaluacion->usuario->maternalSurname }}
                                                    </span>
                                                    <br>
                                                    <span class="text-muted">{{ $evaluacion->usuario->matricula }}</span>
                                                </div>
                                                <div>
                                                    <span
                                                        class="badge bg-info text-white">{{ $evaluacion->estandar->name }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    @empty
                                        <p class="text-center text-muted">No hay usuarios asignados a este evaluador.</p>
                                    @endforelse
                                </ul>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('expedientes.expedientesAdmin.competencias.evaluadores.asignarEva.create')
@stop

@section('css')
    <style>
        .card {
            display: flex;
            flex-direction: column;
        }

        .card-body {
            flex: 1;
            overflow-y: auto;
        }

        .scrollable-card-body {
            max-height: 100%;
        }
    </style>
@stop

@section('js')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
@stop
