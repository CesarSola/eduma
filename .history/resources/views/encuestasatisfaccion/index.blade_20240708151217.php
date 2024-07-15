<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de Satisfacción</title>
    <style>
        .emoji {
            font-size: 24px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Encuesta de Satisfacción</h1>

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    <form action="/form" method="POST">
        @csrf

        <div>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
        </div>

        @for ($i = 1; $i <= 8; $i++)
        <div>
            <label for="question{{ $i }}">Pregunta {{ $i }}:</label>
            <input type="hidden" id="question{{ $i }}" name="question{{ $i }}" value="">
            <span class="emoji" onclick="setEmoji({{ $i }}, '😀')">😀</span>
            <span class="emoji" onclick="setEmoji({{ $i }}, '😐')">😐</span>
            <span class="emoji" onclick="setEmoji({{ $i }}, '☹️')">☹️</span>
        </div>
        @endfor

        <div>
            <label for="doubts">Dudas:</label>
            <textarea id="doubts" name="doubts"></textarea>
        </div>

        <button type="submit">Enviar</button>
    </form>

    <script>
        function setEmoji(questionNumber, emoji) {
            document.getElementById('question' + questionNumber).value = emoji;
        }
    </script>
</body>
</html>
