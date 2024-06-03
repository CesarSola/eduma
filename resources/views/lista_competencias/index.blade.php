@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Estandraes</h1>
@stop

@section('content')
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
   Nuevo
</button>

<table id="cursos-table" class="table table-bordered table-hover ">
    <thead  class="table table-bordered table-hover text-center">
        <tr>
            <th>Numero</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>D.necesarios</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($competencias as $competencias)
        <tr>
            <td>{{$competencias->numero}}</td>
            <td>{{$competencias->name}}</td>
            <td>{{$competencias->tipo}}</td>
            <td>
                {{$competencias->Dnecesarios}}</td>

            <td>
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $competencias->id }}">
                    <i class="fas fa-edit fa-sm"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf fa-sm"></i>
                </button>
                <a href="{{ route('competenciasAD.show', $competencias->id) }}" class="btn btn-info btn-sm">
                    <i class="fas fa-user-plus fa-sm"></i>
                </a>
            </td>

        </tr>




        <div class="modal fade" id="editModal{{ $competencias->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $competencias->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $competencias->id }}">Editar competencias</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('lista_competencias.edit')
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table>

@include('lista_competencias.create')


@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@stop

@section('js')
    <script src="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" ></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cursos-table').DataTable();
        });
    </script>
@stop
