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
            @foreach ($usuariosAdmin as $user)
                <tr style="text-align: center">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->secondName }}</td>
                    <td>{{ $user->paternalSurname }}</td>
                    <td>{{ $user->maternalSurname }}</td>
                    <td>{{ $user->age }}</td>
                    <td>{{ $user->matricula ?? 'N/A' }}</td>
                    <td>
                        @if ($user->documentos->isNotEmpty() && $user->documentos->first()->ine_ife)
                            <a href="{{ asset(str_replace('public/', 'storage/', $user->documentos->first()->ine_ife)) }}"
                                target="_blank">Ver INE</a>
                        @else
                            No disponible
                        @endif
                    </td>
                    <td>
                        @if ($user->documentos->isNotEmpty() && $user->documentos->first()->comprobante_domiciliario)
                            <a href="{{ asset(str_replace('public/', 'storage/', $user->documentos->first()->comprobante_domiciliario)) }}"
                                target="_blank">Ver Comprobante</a>
                        @else
                            No disponible
                        @endif
                    </td>
                    <td>
                        @if ($user->documentos->isNotEmpty() && $user->documentos->first()->foto)
                            <a href="{{ asset(str_replace('public/', 'storage/', $user->documentos->first()->foto)) }}"
                                target="_blank">Ver Foto</a>
                        @else
                            No disponible
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('usuariosAdmin.show', $user->id) }}" class="btn btn-primary">Ver</a>
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
