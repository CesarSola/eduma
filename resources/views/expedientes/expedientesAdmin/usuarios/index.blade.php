@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>USUARIOS</h1>
    </div>
@stop

@section('content')
    <div id="1">
        <div class="card">
            <div class="card-title">
                <div class="text-center">
                    <p>EXPEDIENTES</p>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr style="text-align: center">
                                <th scope="col">id</th>
                                <th scope="col">Primer Nombre</th>
                                <th scope="col">Segundo Nombre</th>
                                <th scope="col">Apellido Paterno</th>
                                <th scope="col">Apellido Materno</th>
                                <th scope="col">Edad</th>
                                <th scope="col">Matrícula</th>
                                <th scope="col">INE</th>
                                <th scope="col">CURP</th>
                                <th scope="col">Comprobante Domiciliario</th>
                                <th scope="col">Foto</th>
                                <th scope="col">Expediente</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($usuariosAsignados->isEmpty())
                                <tr>
                                    <td colspan="12" class="text-center">Aún no tiene ningún usuario asignado, solicita a
                                        tu administrador la asignación de usuarios para poder evaluarlos</td>
                                </tr>
                            @else
                                @foreach ($usuariosAsignados as $usuario)
                                    <tr style="text-align: center">
                                        <td>{{ $usuario->id }}</td>
                                        <td>{{ $usuario->name }}</td>
                                        <td>{{ $usuario->secondName }}</td>
                                        <td>{{ $usuario->paternalSurname }}</td>
                                        <td>{{ $usuario->maternalSurname }}</td>
                                        <td>{{ $usuario->age }}</td>
                                        <td>{{ $usuario->matricula ?? 'N/A' }}</td>
                                        <td>
                                            @if ($usuario->documentos && $usuario->documentos->first() && $usuario->documentos->first()->ine_ife)
                                                <object
                                                    data="{{ asset(str_replace('public/', 'storage/', $usuario->documentos->first()->ine_ife)) }}"
                                                    type="application/pdf" width="100" height="100">
                                                    <a href="{{ asset(str_replace('public/', 'storage/', $usuario->documentos->first()->ine_ife)) }}"
                                                        target="_blank">Ver INE</a>
                                                </object>
                                            @else
                                                No disponible
                                            @endif
                                        </td>
                                        <td>
                                            @if ($usuario->documentos && $usuario->documentos->first() && $usuario->documentos->first()->comprobante_domiciliario)
                                                <object
                                                    data="{{ asset(str_replace('public/', 'storage/', $usuario->documentos->first()->comprobante_domiciliario)) }}"
                                                    type="application/pdf" width="100" height="100">
                                                    <a href="{{ asset(str_replace('public/', 'storage/', $usuario->documentos->first()->comprobante_domiciliario)) }}"
                                                        target="_blank">Ver Comprobante</a>
                                                </object>
                                            @else
                                                No disponible
                                            @endif
                                        </td>
                                        <td>
                                            @if ($usuario->documentos && $usuario->documentos->first() && $usuario->documentos->first()->curp)
                                                <object
                                                    data="{{ asset(str_replace('public/', 'storage/', $usuario->documentos->first()->curp)) }}"
                                                    type="application/pdf" width="100" height="100">
                                                    <a href="{{ asset(str_replace('public/', 'storage/', $usuario->documentos->first()->curp)) }}"
                                                        target="_blank">Ver Comprobante</a>
                                                </object>
                                            @else
                                                No disponible
                                            @endif
                                        </td>
                                        <td>
                                            @if ($usuario->documentos && $usuario->documentos->first() && $usuario->documentos->first()->foto)
                                                <img src="{{ asset(str_replace('public/', 'storage/', $usuario->documentos->first()->foto)) }}"
                                                    width="100" height="100" />
                                            @else
                                                No disponible
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('usuariosAdmin.show', $usuario->id) }}"
                                                class="btn btn-primary">Ver</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
    <style>
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .left-content {
            width: 70%;
        }

        .right-content {
            width: 30%;
            text-align: right;
        }

        .card-title {
            background-color: #067dd2;
            text-align: center;
            width: 100%;
            color: white;
            border-radius: 5px;
        }

        .card-body {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #5cb8a9;
            border-radius: 5px;
        }

        .list-group-item {
            text-align: center;
            width: 100%;
        }

        .h-100 {
            height: 100%;
        }

        .overflow-auto {
            max-height: 200px;
            /* Ajusta esta altura según sea necesario */
            overflow-y: auto;
        }

        .btn-secondary {
            margin-left: auto;
        }

        .btn-success {
            align-content: center;
            width: 50%;
        }

        .btn-primary {
            width: 100%;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
        }

        .toggle-card {
            cursor: pointer;
        }
    </style>
@stop

@section('js')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para recargar la sección cada 5 minutos
        setInterval(function() {
            $.ajax({
                url: window.location.href, // URL actual, puede ser ajustada según necesidad
                type: 'GET', // Método de solicitud GET
                dataType: 'html', // Tipo de datos esperado (html en este caso)
                success: function(response) {
                    // Actualizar el contenido de la sección específica
                    var updatedContent = $(response).find('#1');
                    $('#1').html(updatedContent.html());
                }
            });
        }, 30000); // 300000 milisegundos = 5 minutos
    </script>
@stop
