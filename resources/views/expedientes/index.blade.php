@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <h1>USUARIOS</h1>
@stop

@section('content')
    <p>EXPEDIENTES</p>

    <table class="table table-striped table-hover">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 8px; text-align: center; border-right: 2px solid color: black;">id</th>
                <th style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Nombre</th>
                <th style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Apellido</th>
                <th style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Matrícula</th>
                <th style="padding: 8px; text-align: center; border-right: 2px solid color: black;">INE</th>
                <th style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Comprobante Domiciliario
                </th>
                <th style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Foto</th>
                <th style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Estado</th>
                <th style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Expediente</th>
            </tr>
        </thead>
        <tbody>
            <tr style="background-color: #f9f9f9;">
                <td style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Dato 1</td>
                <td style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Dato 2</td>
                <td style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Dato 1</td>
                <td style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Dato 2</td>
                <td style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Dato 1</td>
                <td style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Dato 2</td>
                <td style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Dato 1</td>
                <td style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Dato 2</td>
                <td style="padding: 8px; text-align: center; border-right: 2px solid color: black;">Dato 2</td>
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
