@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="d-flex justify-content-center align-items-center">
        <div class="text-white bg-success p-3 rounded shadow-sm w-100 text-center">
            <h1 class="mb-0">Subir Comprobante de Pago</h1>
        </div>
    </div>
@stop

@section('content')
    <div class="container">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-success text-white text-center">
                <h6 class="font-weight-bold">Estándar donde te certificarás</h6>
            </div>
            <div class="card-body text-center">
                <h5 class="card-title font-weight-bold">{{ $competencia->numero }} - {{ $competencia->name }}
                    ({{ $competencia->tipo }})</h5>
            </div>
        </div>
        <div class="card mb-4 shadow-sm">
            <div class="alert alert-info text-center shadow-sm mt-4" role="alert">
                <p>Sube el comprobante de pago verificando que el monto sea el que te dió tu
                    @if ($evaluador)
                        <strong>Evaluador:</strong> {{ $evaluador->evaluador->name }}
                        {{ $evaluador->evaluador->secondName }} {{ $evaluador->evaluador->paternalSurname }}
                        {{ $evaluador->evaluador->maternalSurname }}
                    @else
                        <span class="text-muted">Sin evaluador asignado</span>
                    @endif
                    para empezar el proceso de certificación.
                </p>
            </div>
            <div class="card-body">
                @if ($comprobanteExistente)
                    <!-- Si el comprobante existe, muestra el PDF en un modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#pdfModal">
                        Ver Comprobante Existente
                    </button>
                @else
                    <div class="card border-primary">
                        <div class="card-header bg-success text-white text-center">
                            <h6 class="font-weight-bold">Sube tu comprobante</h6>
                        </div>
                        <div class="card-body">
                            <div class="small-form-container">
                                <form action="{{ route('certificacion.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="competencia_id" value="{{ $competencia->id }}">
                                    <div class="form-group">
                                        <label for="comprobante_pago" class="font-weight-bold">Comprobante de Pago
                                            (PDF):</label>
                                        <input type="file" name="comprobante_pago" id="comprobante_pago"
                                            class="form-control-file" accept=".pdf" required>
                                    </div>
                                    <div id="pdf-preview" class="mt-3"
                                        style="width: 100%; height: 100%; border: 1px solid #ddd; overflow: hidden;"></div>
                                    <button type="submit" class="btn btn-success">Subir</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <div class="d-flex justify-content-center mt-4">
            <a href="{{ route('evidenciasEC.index', ['id' => $competencia->id, 'name' => $competencia->name]) }}"
                class="btn btn-secondary">Regresar a {{ $competencia->numero }} - {{ $competencia->name }}</a>
        </div>
    </div>
@stop

@section('css')
    <style>
        body {
            background-color: #f4f6f9;
        }

        .card {
            border: none;
            border-radius: 0.5rem;
            background-color: #ffffff;
        }

        .card-header {
            border-radius: 0.5rem 0.5rem 0 0;
            font-size: 1.2rem;
        }

        .card-body {
            font-size: 1rem;
            color: #343a40;
        }

        .alert-info {
            font-size: 1rem;
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }

        .btn {
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn:hover {
            opacity: 0.85;
        }

        .form-control-file {
            border-radius: 0.375rem;
            padding: 0.375rem;
            border: 1px solid #ced4da;
        }

        .small-form-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 15px;
            border: 1px solid #ced4da;
            border-radius: 0.5rem;
            background-color: #f9f9f9;
            box-shadow: 0 0 0.5rem rgba(0, 0, 0, 0.1);
        }
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.3.122/pdf.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('comprobante_pago');
            const pdfPreview = document.getElementById('pdf-preview');

            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file && file.type === 'application/pdf') {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const pdfData = new Uint8Array(e.target.result);

                        pdfjsLib.getDocument({
                            data: pdfData
                        }).promise.then(function(pdf) {
                            pdf.getPage(1).then(function(page) {
                                const scale = 1.5;
                                const viewport = page.getViewport({
                                    scale: scale
                                });

                                const canvas = document.createElement('canvas');
                                const context = canvas.getContext('2d');
                                canvas.height = viewport.height;
                                canvas.width = viewport.width;
                                pdfPreview.innerHTML =
                                    ''; // Limpiar el contenido anterior
                                pdfPreview.appendChild(canvas);

                                const renderContext = {
                                    canvasContext: context,
                                    viewport: viewport
                                };
                                page.render(renderContext).promise.then(function() {
                                    // Ajustar el tamaño del canvas al contenedor
                                    const container = pdfPreview
                                        .getBoundingClientRect();
                                    const canvasWidth = canvas.width;
                                    const canvasHeight = canvas.height;

                                    const scaleX = container.width /
                                        canvasWidth;
                                    const scaleY = container.height /
                                        canvasHeight;
                                    const scale = Math.min(scaleX, scaleY);

                                    canvas.style.width = (canvasWidth * scale) +
                                        'px';
                                    canvas.style.height = (canvasHeight *
                                        scale) + 'px';
                                    canvas.style.margin = '0 auto';
                                    canvas.style.display = 'block';
                                });
                            });
                        }).catch(function(error) {
                            console.error('Error al cargar el PDF:', error);
                        });
                    };
                    reader.readAsArrayBuffer(file);
                } else {
                    pdfPreview.innerHTML = '<p>Por favor, selecciona un archivo PDF válido.</p>';
                }
            });
        });
    </script>
@stop
