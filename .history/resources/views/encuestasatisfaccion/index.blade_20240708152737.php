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

        @foreach([
            '1. ¿La presentación del estándar de competencia y la aplicación del diagnóstico, lo realizaron sin costo para usted?',
            '2. ¿Le proporcionaron la información suficiente y necesaria para iniciar su proceso de evaluación?',
            '3. ¿Durante el proceso de evaluación le dieron trato digno y respetuoso?',
            '4. ¿Le realizaron la evaluación sin que la ECE/OC/CE/EI lo condicionaran a tomar un curso de capacitación?',
            '5. ¿Le presentaron y acordaron con usted el plan de evaluación?',
            '6. ¿Recibió retroalimentación de los resultados de su evaluacion?',
            '7. ¿El evaluador atendió todas sus dudas?',
            '8. ¿Le entregaron el certificado de acuerdo al compromiso establecido?'
        ] as $index => $question)
        <div class="form-group">
            <label for="question{{ $index + 1 }}">{{ $question }}</label>
            <input type="hidden" id="question{{ $index + 1 }}" name="question{{ $index + 1 }}" value="">
            <span class="emoji" onclick="setEmoji({{ $index + 1 }}, '😀')">😀</span>
            <span class="emoji" onclick="setEmoji({{ $index + 1 }}, '😐')">😐</span>
            <span class="emoji" onclick="setEmoji({{ $index + 1 }}, '☹️')">☹️</span>
        </div>
        @endforeach

        <div class="form-group">
            <label for="doubts">¿Tiene algún otro comentario por externar?</label>
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
