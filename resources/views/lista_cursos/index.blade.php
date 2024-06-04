@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cursos</h1>
@stop

@section('content')
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
    <i class="fas fa-plus"></i>
</button>

<div class="table-responsive">
    <table id="cursos-table" class="table table-bordered table-hover">
        <thead  class="table table-bordered table-hover text-center">
            <tr>

                <th class="centered-text">Numero</th>
                <th class="centered-text">Nombre</th>
                <th class="centered-text">Descripción</th>
                <th class="centered-text">Estandar de competencia</th>
                <th class="centered-text">Instructor</th>
                <th class="centered-text">Duración</th>
                <th class="centered-text">Modalidad</th>
                <th class="centered-text">F.Inicio</th>
                <th class="centered-text">F.Finalización</th>
                <th class="centered-text">Costo</th>
                <th class="centered-text">Certificacion</th>
                <th class="centered-text">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cursos as $curso)
            <tr>
                <td>{{$curso->id}}</td>
                <td>{{$curso->name}}</td>
                <td>{{$curso->description}}</td>
                <td>{{$curso->estandares->numero}}</td>
                <td>{{$curso->instructor}}</td>
                <td>{{$curso->duration}}</td>
                <td>{{$curso->modalidad}}</td>
                <td>{{$curso->fecha_inicio}}</td>
                <td>{{$curso->fecha_final}}</td>
                <td>{{$curso->costo}}</td>
                <td>{{$curso->certification}}</td>
                <td>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal{{ $curso->id }}">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger">
                        <i class="fas fa-file-pdf"></i>
                    </button>
                    <button type="button" class="btn btn-success">
                        <i class="fas fa-download"></i>
                    </button>

                </td>
            </tr>

            <!-- Modal de Edición -->
            <div class="modal fade" id="editModal{{ $curso->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $curso->id }}" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $curso->id }}">Editar Curso</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <!-- Formulario de edición -->
                            @include('lista_cursos.edit')

                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal para Crear -->
@include('lista_cursos.create')

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        .centered-text {
            text-align: center;
            font-weight: bold;
        }
    </style>
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cursos-table').DataTable();
        });
    </script>
@stop
