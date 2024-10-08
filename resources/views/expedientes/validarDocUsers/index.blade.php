@extends('adminlte::page')

@section('title', 'Usuarios y Documentos')

@section('content_header')
    <h1 class="text-center">Lista de Usuarios y sus Documentos</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h3 class="card-title">Usuarios Registrados</h3>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="table-success">
                    <tr>
                        <th>Matricula</th>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>INE/IFE</th>
                        <th>Comprobante Domiciliario</th>
                        <th>CURP</th>
                        <th>Foto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->matricula }}</td>
                            <td>{{ $usuario->getFullNameAttribute() }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                @if ($usuario->documentos && $usuario->documentos->first() && $usuario->documentos->first()->ine_ife)
                                    {{ basename($usuario->documentos->first()->ine_ife) }}
                                @else
                                    <span class="text-danger">No disponible</span>
                                @endif
                            </td>
                            <td>
                                @if ($usuario->documentos && $usuario->documentos->first() && $usuario->documentos->first()->comprobante_domiciliario)
                                    {{ basename($usuario->documentos->first()->comprobante_domiciliario) }}
                                @else
                                    <span class="text-danger">No disponible</span>
                                @endif
                            </td>
                            <td>
                                @if ($usuario->documentos && $usuario->documentos->first() && $usuario->documentos->first()->curp)
                                    {{ basename($usuario->documentos->first()->curp) }}
                                @else
                                    <span class="text-danger">No disponible</span>
                                @endif
                            </td>
                            <td>
                                @if ($usuario->documentos && $usuario->documentos->first() && $usuario->documentos->first()->foto)
                                    {{ basename($usuario->documentos->first()->foto) }}
                                @else
                                    <span class="text-danger">No disponible</span>
                                @endif
                            </td>
                            <td>
                                <div class="text-center">
                                    @if (!$usuario->todosDocumentosValidados)
                                        <a href="{{ route('registroGeneral.show', $usuario->id) }}"
                                            class="btn btn-success">Ver</a>
                                    @else
                                        <span class="text-success">Todos los documentos están validados.</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


            @if ($usuarios->hasMorePages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $usuarios->links() }} <!-- Mostrar enlaces de paginación -->
                </div>
            @else
                <div class="text-center mt-4">
                    <span>No hay más usuarios para mostrar.</span>
                </div>
            @endif

        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        /* Estilo personalizado */
        body {
            background-color: #f8f9fa;
            /* Color de fondo claro */
        }

        .card {
            border: 1px solid #007bff;
            /* Borde azul */
        }

        .table-success {
            background-color: #e2f0d9;
            /* Fondo verde claro para el encabezado de la tabla */
        }

        .btn-success {
            background-color: #28a745;
            /* Color verde para el botón "Ver" */
            border-color: #28a745;
            /* Borde verde para el botón "Ver" */
        }

        .btn-success:hover {
            background-color: #218838;
            /* Color verde más oscuro al pasar el mouse */
            border-color: #1e7e34;
            /* Borde más oscuro al pasar el mouse */
        }
    </style>
@stop

@section('js')
    <script>
        console.log('Vista de Usuarios cargada correctamente.');
    </script>
@stop
