@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Estandares de competencia</h1>
@stop

@section('content')
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#create">
    Nuevo
  </button>


    <table class="table table-borderless">
        <thead>
           @foreach ($competencia as $competencia)
           <tr>
            <th>Numero</th>
            <th>Nombre</th>
            <th>Tipo</th>
            <th>Acción</th>

        </tr>
        <tr>
            <td>{{$competencia->id}}</td>
            <td>{{$competencia->name}}</td>
            <td>{{$competencia->tipo}}</td>

            <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#edit">
                    edit
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
        @extends('lista_estandares.create')
    </div>

@stop
@extends('lista_estandares.edit')
@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
