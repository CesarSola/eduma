@extends('adminlte::page')

@section('title', 'Elegir Fecha')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded shadow-sm">
            <h1>Fechas Disponibles</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="alert alert-info">
            <p><strong>Horarios del Estandar:</strong> {{ $estandar->name }} <strong>asignados al usuario:</strong>
                {{ $usuario->name }} {{ $usuario->secondName }} {{ $usuario->paternalSurname }}
                {{ $usuario->maternalSurname }}</p>
            <p><strong>con la matrícula:</strong> {{ $usuario->matricula }}</p>
        </div>
        <div class="card-header">Elige una fecha con su horario</div>
        <div class="card-body">
            <form action="{{ route('fechas.store') }}" method="POST">
                @csrf

                <input type="hidden" id="fecha_competencia_id" name="fecha_competencia_id">

                <div class="form-group">
                    @foreach ($fechas_competencia as $fecha)
                        <div class="card mb-3">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="d-flex flex-column">
                                        <h5 class="card-title mb-0">Fecha:</h5>
                                        <div>{{ $fecha->fecha->format('d/m/Y') }}</div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h5 class="card-title mb-0">Horario:</h5>
                                        @foreach ($fecha->horarios as $horario)
                                            <div>{{ $horario->horaFormatted }}</div>
                                        @endforeach
                                    </div>
                                    <div class="d-flex flex-column">
                                        @foreach ($fecha->horarios as $horario)
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="horario_id"
                                                    id="horario_{{ $horario->id }}" value="{{ $horario->id }}"
                                                    data-fecha-id="{{ $fecha->id }}">
                                                <label class="form-check-label" for="horario_{{ $horario->id }}">
                                                    <span class="status-label"
                                                        id="status_{{ $horario->id }}">Elegido</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </form>
        </div>
    </div>
@stop
@section('css')
    <style>
        .card {
            background-color: #f9f9f9;
            border: 1px solid #24b83a;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .alert-info {
            color: #14600c;
            background-color: #a8ffb8;
            border-color: #a0f9b6;
            padding: 10px;
            border-radius: 5px;
        }

        .alert {
            padding: 1rem 1.5rem;
            border-radius: .375rem;
            /* Bordes redondeados */
            font-size: 1rem;
            /* Tamaño de fuente */
        }

        /* Texto centrado */
        .alert p {
            margin-bottom: 0;
            text-align: center;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #007302;
            background-color: #fff;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
        }

        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .btn-sm {
            font-size: 0.8em;
            padding: 0.25em 0.5em;
        }

        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
        }

        .thead-dark th {
            color: #fff;
            background-color: #00366d;
            border-color: #454d55;
        }

        .text-primary {
            color: #007bff !important;
        }


        /* Sombra sutil */
        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
        }

        /* Márgenes y rellenos */
        .mt-4 {
            margin-top: 1.5rem !important;
        }
    </style>
    <style>
        .form-check {
            position: relative;
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .form-check-input {
            position: relative;
            width: 2rem;
            /* Ajusta el tamaño del checkbox */
            height: 2rem;
            /* Ajusta el tamaño del checkbox */
            cursor: pointer;
            appearance: none;
            /* Elimina el estilo predeterminado del checkbox */
            background-color: #f0f0f0;
            /* Fondo del checkbox */
            border: 2px solid #ccc;
            /* Borde del checkbox */
            border-radius: 0.25rem;
            /* Bordes redondeados para un efecto cuadrado */
            transition: background-color 0.3s, border-color 0.3s;
            /* Transiciones para los cambios de color */
        }

        .form-check-input:checked {
            background-color: #1aff00;
            /* Fondo cuando está seleccionado */
            border-color: #1aff00;
            /* Borde cuando está seleccionado */
        }

        .form-check-input:checked::before {
            content: '';
            /* Elimina el contenido textual */
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 1.50rem;
            /* Ajusta el tamaño del SVG */
            height: 1.50rem;
            /* Ajusta el tamaño del SVG */
            background: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"%3E%3Cpath d="M9 16.2l-4.2-4.2 1.4-1.4L9 13.4l10-10 1.4 1.4L9 16.2z" fill="%23ffffff"/%3E%3C/svg%3E') center/contain no-repeat;
            /* SVG en blanco */
            z-index: 1;
        }

        .form-check-input:focus {
            outline: none;
            /* Elimina el contorno predeterminado del foco */
            box-shadow: 0 0 0 0.2rem #34ff26;
            /* Sombra de enfoque */
        }

        .status-label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 0.75rem;
            color: #fff;
            font-weight: bold;
            z-index: 2;
            opacity: 0;
            /* Oculto por defecto */
            transition: opacity 0.3s;
            /* Transición para el efecto de animación */
        }

        .form-check-input:checked+.form-check-label .status-label {
            opacity: 1;
            /* Mostrar cuando el checkbox está seleccionado */
        }
    </style>
@stop

@section('js')
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Función para recargar la sección cada 5 minutos
        setInterval(function() {
            $.ajax({
                url: window.location.href, // URL actual, puede ser ajustada según necesidad
                type: 'GET', // Método de solicitud GET
                dataType: 'html', // Tipo de datos esperado (html en este caso)
                success: function(response) {
                    // Actualizar el contenido de la sección específica
                    var updatedContent = $(response).find('#1');
                    $('#1').html(updatedContent.html());
                }
            });
        }, 3000); // 300000 milisegundos = 5 minutos
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.form-check-input').forEach(input => {
            input.addEventListener('change', function() {
                document.querySelectorAll('.form-check-input').forEach(i => {
                    document.getElementById('status_' + i.value).textContent =
                        ''; // Clear all status labels
                });
            });
        });
    </script>
    <script>
        document.querySelectorAll('.form-check-input').forEach(input => {
            input.addEventListener('change', function() {
                // Actualizar el campo oculto con el ID de la fecha correspondiente
                document.getElementById('fecha_competencia_id').value = this.getAttribute('data-fecha-id');
            });
        });
    </script>

@stop
