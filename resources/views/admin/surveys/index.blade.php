@extends('adminlte::page')

@section('title', 'Encuestas de Satisfacción')

@section('content_header')
    <h1>Encuestas de Satisfacción</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Pregunta 1</th>
                <th>Pregunta 2</th>
                <th>Pregunta 3</th>
                <th>Pregunta 4</th>
                <th>Pregunta 5</th>
                <th>Pregunta 6</th>
                <th>Pregunta 7</th>
                <th>Pregunta 8</th>
                <th>Comentarios</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($surveys as $survey)
                <tr>
                    <td>{{ $survey->name }}</td>
                    <td>{{ $survey->question1 }}</td>
                    <td>{{ $survey->question2 }}</td>
                    <td>{{ $survey->question3 }}</td>
                    <td>{{ $survey->question4 }}</td>
                    <td>{{ $survey->question5 }}</td>
                    <td>{{ $survey->question6 }}</td>
                    <td>{{ $survey->question7 }}</td>
                    <td>{{ $survey->question8 }}</td>
                    <td>{{ $survey->doubts }}</td>
                    <td>
                        <a href="{{ route('admin.surveys.downloadIndividual', $survey->id) }}" class="btn btn-primary">Descargar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop
