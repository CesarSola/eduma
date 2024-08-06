@extends('adminlte::page')

@section('title', 'Encuesta de Satisfacción')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Encuesta de Satisfacción</h1>
        <img src="{{ asset('assets/img/logo.jpeg') }}" alt="Logo de la Empresa" style="width: 200px;">
    </div>
@stop

@section('content')
@if (session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

    @if ($standardName)
        <div class="alert alert-info">
            <strong>Estándar de Competencia:</strong> {{ $standardName }}
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <p>Por favor, responda las siguientes preguntas seleccionando la carita que mejor represente su opinión:</p>
    <ul>
        <li>😀 Muy de acuerdo</li>
        <li>🙂 De acuerdo</li>
        <li>😐 Parcialmente en desacuerdo</li>
        <li>☹️ Totalmente en desacuerdo</li>
    </ul>

    <form action="{{ route('form.submit', ['estandar_id' => $estandar_id]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="exam_date">Fecha del Examen:</label>
            <input type="date" class="form-control" id="exam_date" name="exam_date" value="{{ old('exam_date') }}" required>
        </div>

        <!-- Tabla de preguntas -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Pregunta</th>
                    <th>Muy de acuerdo</th>
                    <th>De acuerdo</th>
                    <th>Parcialmente en desacuerdo</th>
                    <th>Totalmente en desacuerdo</th>
                </tr>
            </thead>
            <tbody>
                @foreach([
                    '1. ¿La presentación del estándar de competencia y la aplicación del diagnóstico, lo realizaron sin costo para usted?',
                    '2. ¿Le proporcionaron la información suficiente y necesaria para iniciar su proceso de evaluación?',
                    '3. ¿Durante el proceso de evaluación le dieron trato digno y respetuoso?',
                    '4. ¿Le realizaron la evaluación sin que la ECE/OC/CE/EI lo condicionaran a tomar un curso de capacitación?',
                    '5. ¿Le presentaron y acordaron con usted el plan de evaluación?',
                    '6. ¿Recibió retroalimentación de los resultados de su evaluación?',
                    '7. ¿El evaluador atendió todas sus dudas?',
                    '8. ¿Le entregaron el certificado de acuerdo al compromiso establecido?'
                ] as $index => $question)
                <tr>
                    <td>{{ $question }}</td>
                    <td><span class="emoji" onclick="setEmoji({{ $index + 1 }}, '😀')">😀</span></td>
                    <td><span class="emoji" onclick="setEmoji({{ $index + 1 }}, '🙂')">🙂</span></td>
                    <td><span class="emoji" onclick="setEmoji({{ $index + 1 }}, '😐')">😐</span></td>
                    <td><span class="emoji" onclick="setEmoji({{ $index + 1 }}, '☹️')">☹️</span></td>
                    <input type="hidden" id="question{{ $index + 1 }}" name="question{{ $index + 1 }}" value="{{ old('question' . ($index + 1)) }}">
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="form-group">
            <label for="doubts">¿Tiene algún otro comentario por externar?</label>
            <textarea class="form-control" id="doubts" name="doubts">{{ old('doubts') }}</textarea>
        </div>

        <!-- Campo oculto para user_id -->
        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">

        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

    <script>
        function setEmoji(questionNumber, emoji) {
            // Remove 'selected' class from all emojis for the current question
            document.querySelectorAll('tr').forEach(function(tr) {
                if (tr.querySelector('input[id="question' + questionNumber + '"]')) {
                    tr.querySelectorAll('.emoji').forEach(function(el) {
                        el.style.border = 'none'; // Eliminar bordes de todos
                    });
                }
            });

            // Add border to the clicked emoji
            event.target.style.border = '1px solid blue'; // Añadir borde azul

            // Set the hidden input value
            document.getElementById('question' + questionNumber).value = emoji;
        }

        // Cuando el documento se carga, restaurar selecciones previas
        document.addEventListener('DOMContentLoaded', function() {
            // Iterar sobre cada pregunta
            @foreach(range(1, 8) as $index)
                var selectedEmoji = '{{ old('question' . $index) }}';
                if (selectedEmoji) {
                    // Obtener el emoji seleccionado y marcarlo
                    var emojiElements = document.querySelectorAll('tr');
                    emojiElements.forEach(function(tr) {
                        if (tr.querySelector('input[id="question{{ $index }}"]')) {
                            tr.querySelectorAll('.emoji').forEach(function(el) {
                                if (el.textContent.trim() === selectedEmoji) {
                                    el.style.border = '1px solid blue';
                                }
                            });
                        }
                    });
                }
            @endforeach
        });
    </script>
@stop

@section('css')
    <style>
        .emoji {
            font-size: 24px;
            cursor: pointer;
            margin-right: 10px;
            border: none; /* Eliminar bordes iniciales */
        }
        .table th, .table td {
            text-align: center;
        }
        .d-flex {
            display: flex;
        }
        .justify-content-between {
            justify-content: space-between;
        }
        .align-items-center {
            align-items: center;
        }
    </style>
@stop
