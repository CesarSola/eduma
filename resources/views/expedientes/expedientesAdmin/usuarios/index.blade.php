@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <h1>USUARIOS</h1>
@stop

@section('content')
    <p>EXPEDIENTES</p>
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
                        @if ($usuario->documentos->isNotEmpty() && $usuario->documentos->first()->ine_ife)
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
                        @if ($usuario->documentos->isNotEmpty() && $usuario->documentos->first()->comprobante_domiciliario)
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
                        @if ($usuario->documentos->isNotEmpty() && $usuario->documentos->first()->foto)
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
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
