@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cursos</h1>
@stop

@section('content')
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
    Nuevo
</button>

<table id="cursos-table" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Numero</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Estandar de competencia</th>
            <th>Instructor</th>
            <th>Duración</th>
            <th>Modalidad</th>
            <th>Fecha de inicio</th>
            <th>Fecha de finalizacion</th>
            <th>Plataforma</th>
            <th>Costo</th>
            <th>Certificacion</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cursos as $curso)
        <tr>
            <td>{{$curso->id}}</td>
            <td>{{$curso->name}}</td>
            <td>{{$curso->description}}</td>
            <td>{{$curso->competencia}}</td>
            <td>{{$curso->instructor}}</td>
            <td>{{$curso->duration}}</td>
            <td>{{$curso->modalidad}}</td>
            <td>{{$curso->fecha_inicio}}</td>
            <td>{{$curso->fecha_final}}</td>
            <td>{{$curso->plataforma}}</td>
            <td>{{$curso->costo}}</td>
            <td>{{$curso->certification}}</td>
            <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit">
                   edit
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@include('lista_cursos.create')
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cursos-table').DataTable();
        });
    </script>
@stop
