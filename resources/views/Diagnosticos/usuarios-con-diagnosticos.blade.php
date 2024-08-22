@extends('adminlte::page')

@section('title', 'Diagnósticos asignados')

@section('content_header')
@php
$user = Auth::user();
@endphp
@if ($user->rol === 'Admin' || $user->rol === 'Evaluador')
<div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-bold">Asignar diagnósticos a usuarios</h1>
    <a href="{{ route('usuarios.asignar-diagnosticos') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
        Regresar
    </a>
</div>
@endif

@stop

@section('content')


@if ($user->rol === 'Admin' || $user->rol === 'Evaluador')
    <!-- El contenido que deseas mostrar para Admin o Evaluador -->

    <table id="usuarios-diagnosticos-table" class="min-w-full bg-white border border-gray-300 rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Usuario</th>
                <th class="py-3 px-6 text-left">Estado</th>
            </tr>
        </thead>
        <tbody class="text-black-600 text-sm font-light">
            @foreach($usuarios as $usuario)
                <tr class="border-b border-blue-200 hover:bg-gray-100">
                    <td class="py-3 px-6">{{ $usuario->name }}</td>
                    <td class="py-3 px-6">
                        @if($usuario->diagnosticos->isNotEmpty())
                            <ul class="list-disc ml-4">
                                @foreach($usuario->diagnosticos as $diagnostico)
                                    <li>{{ $diagnostico->codigo }} - {{ $diagnostico->nombre }}</li><br>
                                @endforeach
                            </ul>
                        @else
                            <span class="text-gray-500">No tiene diagnósticos asignados.</span>
                        @endif
                    </td>
                    <td class="py-3 px-6">
                        @foreach($usuario->diagnosticos as $diagnostico)
                            @if($diagnostico->codigo == "EC0301")
                                <a href="{{ route('formulario') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block mb-2">
                                    <i class="fas fa-eye fa-sm"></i> Ver
                                </a><br>
                            @elseif($diagnostico->codigo == "EC0076" || $diagnostico->codigo == "EC217.01")
                                <a href="{{ route('formulario2') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block mb-2">
                                    <i class="fas fa-eye fa-sm"></i> Ver
                                </a><br>
                            @endif
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@elseif($user->rol === 'User')
    <p class="text-lg mb-4">Hola, {{ $user->name }}</p>
    <h3 class="text-xl font-bold mb-4">Mis Diagnósticos Asignados</h3>
    <table id="usuarios-diagnosticos-table" class="min-w-full bg-white border border-gray-300 rounded-lg">
        <thead>
            <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <th class="py-3 px-6 text-left">Diagnóstico</th>
                <th class="py-3 px-6 text-left">Estado</th>
            </tr>
        </thead>
        <tbody class="text-gray-600 text-sm font-light">
            @foreach($user->diagnosticos as $diagnostico)
                <tr class="border-b border-gray-200 hover:bg-gray-100">
                    <td class="py-3 px-6">{{ $diagnostico->codigo }} - {{ $diagnostico->nombre }}</td>
                    <td class="py-3 px-6">
                        @if($diagnostico->codigo == "EC0301")
                            <a href="{{ route('formulario') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block mb-2">
                                <i class="fas fa-eye fa-sm"></i> Ver
                            </a>
                        @elseif($diagnostico->codigo == "EC0076" || $diagnostico->codigo == "EC098")
                            <a href="{{ route('formulario2') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-block mb-2">
                                <i class="fas fa-eye fa-sm"></i> Ver
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
@stop

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- Include Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#usuarios-diagnosticos-table').DataTable({
                "language": {
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "zeroRecords": "No se encontraron resultados",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(filtrado de _MAX_ registros totales)",
                    "paginate": {
                        "first": "Primero",
                        "last": "Último",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>
@stop
