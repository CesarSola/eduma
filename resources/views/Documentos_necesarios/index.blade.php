@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Documentos necesarios por estandar</h1>
@stop

@section('content')
<!-- Button trigger modal -->
<div class="mb-4">

     <button data-modal-target="create-modal" data-toggle="modal" data-target="#create" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
        Crear nuevo documento
      </button>
</div>


<table id="cursos-table" class="table table-bordered table-hover ">
    <thead  class="table table-bordered table-hover text-center">
        <tr>

            <th>Nombre</th>
            <th>Descripcion</th>

            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($documentosnec as $documentosnec)
        <tr>
            <td>{{$documentosnec->name}}</td>
            <td>{{$documentosnec->description}}</td>

            <td>
                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $documentosnec->id }}">
                    <i class="fas fa-edit fa-sm"></i>
                </button>
                <button type="button" class="btn btn-danger btn-sm">
                    <i class="fas fa-file-pdf fa-sm"></i>

            </td>

        </tr>
        <div class="modal fade" id="editModal{{ $documentosnec->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $documentosnec->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel{{ $documentosnec->id }}">Editar documentos nececesarios</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @include('Documentos_necesarios.edit')
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>

        @endforeach




    </tbody>
</table>


  @include('Documentos_necesarios.create')

@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
