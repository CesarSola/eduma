@extends('adminlte::page')

@section('title', 'Resubir')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded shadow-sm">
            <h1 class="mb-0">Resubir Documentos</h1>
        </div>
        <a href="{{ route('mis.evidencias', ['id' => $evidencia->estandar_id, 'name' => $evidencia->estandar->name]) }}"
            class="btn btn-secondary shadow-sm">Regresar</a>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card mt-4 shadow-sm">
            <div class="card-body">
                <h6 class="card-header text-secondary font-weight-bold">{{ $usuario->name }} {{ $usuario->secondName }}
                    {{ $usuario->paternalSurname }} {{ $usuario->maternalSurname }}, sube de nuevo el documento marcado aqui
                    para su revisión</h6>

                {{-- Mostrar el nombre del documento rechazado --}}
                <div class="alert alert-info">
                    <p><strong>Nombre del documento rechazado: </strong>
                        {{ optional($evidencia->documento)->name }}<strong> para el Estándar: </strong>
                        {{ optional($evidencia->estandar)->name }}</p>
                </div>


                <form action="{{ route('evidencias.resubir.submit', $evidencia->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Seleccionar archivo</label>
                        <input type="file" id="file" name="file" class="form-control" accept=".pdf" required>
                        <small class="form-text text-muted">Asegúrate de que tu archivo sea en formato PDF para poder
                            subirlo.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Subir Documento</button>
                </form>
            </div>
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
            color: #0c5460;
            background-color: #d1ecf1;
            border-color: #bee5eb;
            padding: 10px;
            border-radius: 5px;
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

        /* Colores personalizados */
        .alert-secondary {
            background-color: #f8f9fa;
            /* Fondo claro */
            border-color: #ced4da;
            /* Borde gris */
            color: #6c757d;
            /* Texto gris */
        }

        /* Sombra sutil */
        .shadow-sm {
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
        }

        /* Márgenes y rellenos */
        .mt-4 {
            margin-top: 1.5rem !important;
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
@stop
