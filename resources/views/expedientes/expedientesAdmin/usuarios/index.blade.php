@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>USUARIOS</h1>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-title">
            <div class="text-center">
                <p>EXPEDIENTES</p>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
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
                    @foreach ($usuariosAdmin as $usuario)
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
                                <a href="{{ route('usuariosAdmin.show', $usuario->id) }}" class="btn btn-primary">Ver</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
@section('css') <style>
        .card-title {
            background-color: #067dd2;
            padding: 10px;
            color: white;
            border-radius: 5px;
        }

        .card-header h3 {
            margin: 0;
        }

        .card-body {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #5cb8a9;
            border-radius: 5px;
        }

        .text-center {
            color: #ffffff;
        }

        .text-left {
            color: #000;
        }

        .d-flex.align-items-center h6 {
            margin-bottom: 0;
        }

        .toggle-card {
            cursor: pointer;
        }
    </style>
@stop

@section('js')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
