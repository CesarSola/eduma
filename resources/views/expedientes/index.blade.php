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
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Matrícula</th>
                <th scope="col">INE</th>
                <th scope="col">Comprobante Domiciliario</th>
                <th scope="col">Foto</th>
                <th scope="col">Estado</th>
                <th scope="col">Expediente</th>
            </tr>
        </thead>
        <tbody>
            <tr style="text-align: center">
                <td>1</td>
                <td>2</td>
                <td>3</td>
                <td>4</td>
                <td>5</td>
                <td>6</td>
                <td>7</td>
                <td>8</td>
                <td>
                    <form action="{{ route('usuarios.index') }}" method="GET">
                        <button type="submit" class="btn btn-primary"> Ver Expediente</button>
                    </form>
                </td>
            </tr>
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
