@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Documentos necesarios por estándar</h1>
@stop

@section('content')
    <!-- Button trigger modal -->
    <div class="mb-4">
        <button data-modal-target="create-modal" data-toggle="modal" data-target="#create"
            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            Crear nuevo documento
        </button>
    </div>

    <table id="documentos-table" class="table table-bordered table-hover">
        <thead class="text-center">
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($documentosnec as $documento)
                <tr>
                    <td>{{ $documento->name }}</td>
                    <td>{{ $documento->description }}</td>
                    <td class="text-center">
                        <!-- Enlace para ver el documento -->
                        <a href="{{ Storage::url($documento->documento) }}" target="_blank" class="btn btn-danger btn-sm">
                            <i class="fas fa-file-pdf fa-sm"></i> Ver PDF
                        </a>
                        <!-- Botón para editar el documento -->
                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                            data-target="#editModal{{ $documento->id }}">
                            <i class="fas fa-edit fa-sm"></i> Editar
                        </button>
                    </td>
                </tr>

                <!-- Modal para editar documento -->
                <div class="modal fade" id="editModal{{ $documento->id }}" tabindex="-1"
                    aria-labelledby="editModalLabel{{ $documento->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $documento->id }}">Editar documento necesario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                @include('Documentos_necesarios.edit')
                            </div>
                            <div class="modal-footer">
                                <!-- Puedes agregar botones adicionales aquí si es necesario -->
                            </div>
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
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#documentos-table').DataTable();
        });
    </script>
@stop
