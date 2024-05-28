@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <h1>USUARIOS</h1>
@stop

@section('content')
    <p>EXPEDIENTES</p>
    <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 8px; text-align: left;">id</th>
                <th style="padding: 8px; text-align: left;">Nombre</th>
                <th style="padding: 8px; text-align: left;">Apellido</th>
                <th style="padding: 8px; text-align: left;">Nombre</th>
                <th style="padding: 8px; text-align: left;">Nombre</th>
                <th style="padding: 8px; text-align: left;">Nombre</th>
                <th style="padding: 8px; text-align: left;">Nombre</th>

            </tr>
        </thead>
        <tbody>
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 8px; text-align: left;">Dato 1</td>
                <td style="padding: 8px; text-align: left;">Dato 2</td>
                <!-- Agrega más datos según sea necesario -->
            </tr>
            <!-- Agrega más filas de datos según sea necesario -->
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
