@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Competencias</h1>
        <a href="{{ route('usuariosAdmin.show', ['usuariosAdmin' => $usuario->id]) }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <!-- Información del usuario -->
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4 shadow-sm border-light">
                <div class="card-body d-flex align-items-center p-4">
                    <!-- Foto del usuario -->
                    <div class="rounded-circle overflow-hidden mr-3" style="width: 60px; height: 60px;">
                        <img src="{{ $usuario->foto }}" alt="Profile Picture" class="img-fluid rounded-circle" width="60"
                            height="60" onerror="this.src='{{ asset('assets/profile-default/profile_default.jpeg') }}';">
                    </div>
                    <!-- Información del usuario -->
                    <div>
                        <p class="mb-1 text-dark font-weight-bold" style="font-size: 1rem;"><strong>Nombres:</strong>
                            {{ $usuario->name }} {{ $usuario->secondName }}</p>
                        <p class="mb-1 text-dark font-weight-bold" style="font-size: 1rem;"><strong>Apellidos:</strong>
                            {{ $usuario->paternalSurname }} {{ $usuario->maternalSurname }}</p>
                        <p class="mb-0 text-dark font-weight-bold" style="font-size: 1rem;"><strong>Edad:</strong>
                            {{ $usuario->age }} años</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tarjeta de Evidencias del Usuario -->
    <div class="card mb-4 shadow-sm border-primary">
        <div class="card-body bg-light">
            <h5 class="card-title mb-3 text-white bg-primary p-2 rounded">Evidencias del Usuario</h5>
            <table class="table table-striped table-hover mb-0 border-primary">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>No.</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Evidencias del Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($competencias as $competencia)
                        <tr>
                            <td>{{ $competencia->id }}</td>
                            <td>{{ $competencia->name }}</td>
                            <td>{{ $competencia->tipo }}</td>
                            <td>
                                <a href="{{ route('evidenciasACO.index', ['competencia' => $competencia->id, 'user_id' => $usuario->id]) }}"
                                    class="btn btn-primary btn-sm">Ver Evidencias</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tarjeta de Fechas y Horarios Asignados -->
    <div class="card mb-4 shadow-sm border-success">
        <div class="card-body bg-light">
            <h5 class="card-title mb-3 text-white bg-success p-2 rounded">Fechas y Horarios Asignados</h5>
            <table class="table table-striped table-hover mb-0 border-success">
                <thead class="bg-success text-white">
                    <tr>
                        <th>No.</th>
                        <th>Competencias</th>
                        <th>Fechas Asignadas</th>
                        <th>Horarios Asignados</th>
                        <th>Agregar Fechas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($competencias as $competencia)
                        <tr>
                            <td>{{ $competencia->id }}</td>
                            <td>{{ $competencia->name }}</td>
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($competencia->fechas as $fecha)
                                        <li><strong>{{ $fecha->fecha->format('d/m/Y') }}</strong></li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($competencia->fechas as $fecha)
                                        @foreach ($fecha->horarios as $horario)
                                            <li><strong>{{ $horario->hora }}</strong></li>
                                        @endforeach
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <p class="mb-0">Para asignar fechas y horarios a este usuario, ve a la pestaña de <a
                                        href="{{ route('calendario.index') }}" class="btn btn-success btn-sm">Mis
                                        Usuarios</a></p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card-title {
            background-color: #067dd2;
            padding: 10px;
            color: white;
            border-radius: 5px;
        }

        .card-header h3 {
            margin: 0;
        }

        .card-body {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #5cb8a9;
            border-radius: 5px;
        }

        .right-content {
            text-align: right;
        }

        .right-content div {
            margin-bottom: 5px;
            /* Espacio entre cada badge */
        }

        .text-center {
            color: #000000;
        }

        .text-left {
            color: #000;
        }

        .d-flex.align-items-center h6 {
            margin-bottom: 0;
        }

        .toggle-card {
            cursor: pointer;
        }
    </style>
@stop

@section('js')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
