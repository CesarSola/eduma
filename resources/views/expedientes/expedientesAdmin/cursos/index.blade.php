@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Competencias</h1>
        <a href="{{ route('usuariosAdmin.show', ['usuariosAdmin' => $usuario->id]) }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body header-flex">
                    <div class="left-content">
                        <div class="text-center">
                            <img src="{{ asset('path_to_default_avatar') }}" alt="" class="img-circle">
                        </div>
                        <p>Nombres: {{ $usuario->name }} {{ $usuario->secondName }}</p>
                        <p>Apellidos: {{ $usuario->paternalSurname }} {{ $usuario->maternalSurname }}</p>
                        <p>Edad: {{ $usuario->age }} años</p>
                    </div>
                    <div class="right-content">
                        <span class="badge badge-info">Estatus: Activo</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Estandar Relacionado</th>
                        <th>Instructor</th>
                        <th>Duracion(hr)</th>
                        <th>Modalidad</th>
                        <th>Fecha de Inicio</th>
                        <th>Fecha de Conclusión</th>
                        <th>Costo</th>
                        <th>Certificación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cursos as $curso)
                        <tr>
                            <td>{{ $curso->id }}</td>
                            <td>{{ $curso->name }}</td>
                            <td>{{ $curso->description }}</td>
                            <td>{{ $curso->id_estandar }}</td>
                            <td>{{ $curso->instructor }}</td>
                            <td>{{ $curso->duration }}</td>
                            <td>{{ $curso->modalidad }}</td>
                            <td>{{ $curso->fecha_inicio }}</td>
                            <td>{{ $curso->fecha_final }}</td>
                            <td>{{ $curso->costo }}</td>
                            <td>{{ $curso->certification }}</td>
                            <td> <a href="{{ route('evidenciasACU.index', ['curso' => $curso->id, 'user_id' => $usuario->id]) }}"
                                    class="btn btn-primary">Ver Evidencias</a></td>

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
