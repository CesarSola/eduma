@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cursos</h1>
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
    <div class="mb-4 max-w-sm flex items-center">
        <label for="searchInput" class="mr-2 text-sm font-medium text-gray-700 dark:text-gray-300">Buscar:</label>
        <input type="text" id="searchInput" class="block w-full p-2 border border-gray-300 rounded-lg"
            placeholder="Buscar...">
    </div>

    <div class="overflow-x-auto">
        <table id="documentosnecTable"
            class="min-w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700">
            <thead class="bg-gray-200 dark:bg-gray-700">
                <tr>

                    <th class="py-2 px-4 text-gray-900 dark:text-white">Numero</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Nombre</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Descripción</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Estandar de competencia</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Documentos Necesarios</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Instructor</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Duración</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Modalidad</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">F.Inicio</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">F.Finalización</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Costo</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Certificacion</th>
                    <th class="py-2 px-4 text-gray-900 dark:text-white">Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cursos as $curso)
                    <tr class="border-b border-gray-300 dark:border-gray-700">
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $curso->id }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $curso->name }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $curso->description }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">
                            {{ $curso->estandares ? $curso->estandares->numero : 'N/A' }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">
                            @foreach ($curso->documentosnec as $documento)
                                <a href="{{ Storage::url($documento->documentos) }}" class="block hover:text-blue-600"
                                    download>{{ $documento->name }}</a>
                            @endforeach
                        </td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $curso->instructor }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $curso->duration }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $curso->modalidad }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $curso->fecha_inicio }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $curso->fecha_final }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $curso->costo }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">{{ $curso->certification }}</td>
                        <td class="py-2 px-4 text-gray-700 dark:text-gray-300">
                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                data-target="#editModal{{ $curso->id }}">
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
                    <div class="modal fade" id="editModal{{ $curso->id }}" tabindex="-1"
                        aria-labelledby="editModalLabel{{ $curso->id }}" aria-hidden="true">
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

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const table = document.getElementById('documentosnecTable');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');

            searchInput.addEventListener('keyup', function() {
                const filter = searchInput.value.toLowerCase();
                for (let i = 0; i < rows.length; i++) {
                    const cells = rows[i].getElementsByTagName('td');
                    let match = false;
                    for (let j = 0; j < cells.length; j++) {
                        if (cells[j]) {
                            if (cells[j].innerText.toLowerCase().indexOf(filter) > -1) {
                                match = true;
                                break;
                            }
                        }
                    }
                    if (match) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            });
        });
    </script>
@stop
