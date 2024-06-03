@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
   @foreach ($competencias as $EcInfo)
   <label for="numero">Numero</label>
   <input type="text" class="form-control" id="numero" name="numero" value="{{ $competencias->numero }}" required>
   @endforeach
@stop

@section('content')


@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@stop

@section('js')
    <script src="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" ></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#cursos-table').DataTable();
        });
    </script>
@stop
