@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Estandraes</h1>
@stop
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Lista de Inscripciones3</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Competencia</th>
                                    <th>Fecha de Inscripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inscripciones as $inscripcion)
                                    <tr>
                                        <td>{{ $inscripcion->id }}</td>
                                        <td>{{ $inscripcion->usuario->name }}</td> {{-- Suponiendo que hay un campo "name" en el modelo User --}}
                                        <td>{{ $inscripcion->nombre_competencia }}</td>
                                        <td>{{ $inscripcion->fecha_inscripcion }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
