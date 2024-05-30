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
                <th scope="col">Estado</th>
                <th scope="col">Expediente</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($expedientesAdmin as $user)
                <tr style="text-align: center">
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->secondName }}</td>
                    <td>{{ $user->paternalSurname }}</td>
                    <td>{{ $user->maternalSurname }}</td>
                    <td>{{ $user->age }}</td>
                    <td>6</td>
                    <td>7</td>
                    <td>8</td>
                    <td></td>
                    <td></td>
                    <td>
                        <a href="{{ route('usuarios.show', $user->id) }}" class="btn btn-primary">Ver</a>
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
