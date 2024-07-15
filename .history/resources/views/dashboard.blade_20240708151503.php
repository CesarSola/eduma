@extends('adminlte::page')

@section('title', 'Encuesta de Satisfacción')

@section('content_header')
    <h1>Encuesta de Satisfacción</h1>
@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="/form" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        @for ($i = 1; $i <= 8; $i++)
        <div class="form-group">
            <label for="question{{ $i }}">Pregunta {{ $i }}:</label>
            <input type="hidden" id="question{{ $i }}" name="question{{ $i }}" value="">
            <span class="emoji" onclick="setEmoji({{ $i }}, '😀')">😀</span>
            <span class="emoji" onclick="setEmoji({{ $i }}, '😐')">😐</span>
            <span class="emoji" onclick="setEmoji({{ $i }}, '☹️')">☹️</span>
        </div>
        @endfor

        <div class="form-group">
            <label for="doubts">Dudas:</label>
            <textarea class="form-control" id="doubts" name="doubts"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

    <script>
        function setEmoji(questionNumber, emoji) {
            document.getElementById('question' + questionNumber).value = emoji;
        }
    </script>
@stop

@section('css')
    <style>
        .emoji {
            font-size: 24px;
            cursor: pointer;
        }
    </style>
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
