@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Cursos</h1>
@stop

@section('content')
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
    Nuevo
  </button>


    <table class="table table-borderless">
        <thead>
           @foreach ($cursos as $curso)
           <tr>
            <th>Numero</th>
            <th>Nombre</th>
            <th>Descripcion</th>
            <th>Instructor</th>
            <th>Duración</th>
            <th>Modalidad</th>
            <th>Fecha de inicio</th>
            <th>Fecha de finalizacion</th>
            <th>Plataforma</th>
            <th>Costo</th>
            <th>Certificacion</th>
            <th>Acción</th>

        </tr>
        <tr>
            <td>{{$curso->id}}</td>
            <td>{{$curso->name}}</td>
            <td>{{$curso->description}}</td>
            <td>{{$curso->instructor}}</td>
            <td>{{$curso->duration}}</td>
            <td>{{$curso->modalidad}}</td>
            <td>{{$curso->fecha_inicio}}</td>
            <td>{{$curso->fecha_final}}</td>
            <td>{{$curso->plataforma}}</td>
            <td>{{$curso->costo}}</td>
            <td>{{$curso->certification}}</td>
            <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Nuevo
                  </button>
            </td>
        </tr>
           @endforeach
        </thead>
        <tbody>
            <!-- Aquí puedes iterar sobre los cursos y mostrarlos en la tabla -->
        </tbody>
    </table>


    <!-- Modal de creación de curso -->

        <!-- Aquí deberías incluir el formulario de creación de curso -->
        @extends('lista_cursos.create')
    </div>
    @extends('lista_cursos.edit')
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
