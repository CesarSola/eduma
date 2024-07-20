@extends('adminlte::page')

@section('title', 'Evidencias')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded shadow-sm">
            <h1 class="mb-0">{{ $estandar->name }}</h1>
        </div>
        <a href="{{ route('miscompetencias.index') }}" class="btn btn-secondary shadow-sm">Regresar</a>
    </div>
@stop

@section('content')
    <div id="1">
        <div class="container mt-4">
            <div class="card">
                <div class="card-body text-center">
                    {{-- Mostrar solo si la ficha de registro no ha sido subida --}}
                    @if (!$ficha_registro)
                        <div class="card">
                            <form id="form-ficha-registro"
                                action="{{ route('generate-word', ['userId' => Auth::id(), 'standardId' => $estandar->id]) }}"
                                method="GET">
                                @csrf
                                <div class="mb-3">
                                    <h6 class="card-title text-primary font-weight-bold">Descarga la Ficha de Inscripción
                                    </h6>
                                    <button type="submit" class="btn btn-success btn-sm shadow-sm mt-3">Descargar
                                        Ficha</button>
                                </div>
                            </form>
                    @endif

                    {{-- Mostrar solo si la carta de firma digital no ha sido subida --}}
                    @if (!$carta_firma)
                        <form id="form-carta-aceptacion" action="{{ route('generate-carta', ['userId' => Auth::id()]) }}"
                            method="GET">
                            @csrf
                            <div class="mb-3">
                                <h6 class="card-title text-primary font-weight-bold">Descarga la Carta de Firma Digital</h6>
                                <button type="submit" class="btn btn-success btn-sm shadow-sm mt-3">Descargar
                                    Carta</button>
                            </div>
                        </form>
                    @endif
                </div>

                {{-- Mostrar la sección de subida de documentos solo si ambos documentos no han sido subidos --}}
                @if (!$ficha_registro || !$carta_firma)
                    <div class="container mt-4">
                        <div class="card">
                            <div class="card-body">
                                {{-- Botón para subir la ficha --}}
                                <div class="mb-3">
                                    <h6 class="card-title text-primary font-weight-bold">Sube tu ficha de registro,
                                        verificando que los datos sean correctos y ya firmada</h6>
                                    @if ($ficha_registro)
                                        <br>
                                        <div class="alert alert-secondary shadow-sm mt-4" role="alert">
                                            <p style="margin: 0;">Ya has subido la ficha de registro.</p>
                                        </div>
                                    @else
                                        <a href="{{ route('word.show', ['id' => $estandar->id, 'tipoDocumento' => 'ficha_registro']) }}"
                                            class="btn btn-success btn-sm shadow-sm">Subir ficha</a>
                                    @endif
                                </div>
                                {{-- Botón para subir la carta de aceptación --}}
                                <div class="mb-3">
                                    <h6 class="card-title text-primary font-weight-bold">Sube tu carta de de Firma Digital,
                                        leyendo detalladamente y ya firmada</h6>
                                    @if ($carta_firma)
                                        <br>
                                        <div class="alert alert-secondary shadow-sm mt-4" role="alert">
                                            <p style="margin: 0;">Ya has subido la carta de firma digital.</p>
                                        </div>
                                    @else
                                        <a href="{{ route('word.show', ['id' => $estandar->id, 'tipoDocumento' => 'carta_firma']) }}"
                                            class="btn btn-success btn-sm shadow-sm">Subir carta</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (!$ficha_registro || !$carta_firma)
                        <div class="alert alert-info shadow-sm mt-4" role="alert">
                            Sube tanto la ficha de registro como la carta de tu firma digital, para ver la sección de los
                            documentos
                            necesarios
                            que tienes que subir para este EC.
                        </div>
                    @endif
                @endif
                {{-- Mostrar validaciones solo si la carta y la ficha no están validadas --}}
                @if ($ficha_registro && $carta_firma && (!$carta_validada || !$ficha_validada))
                    <div class="card mt-4 shadow-sm">
                        <div class="card-body">
                            <div class="card-header">
                                <h6 class="card-header text-primary font-weight-bold">Validaciones de Carta y Ficha</h6>
                            </div>
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Documento</th>
                                            <th>Estado</th>
                                            <th>Comentario</th>
                                            <th>Acción</th> <!-- Columna para la acción -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {{-- Validaciones de fichas --}}
                                        @foreach ($fichas_validaciones as $validacion)
                                            <tr>
                                                <td>Ficha de Registro</td>
                                                <td>{{ ucfirst($validacion->estado) }}</td>
                                                <td>{{ $validacion->comentario }}</td>
                                                <td>
                                                    {{-- Lógica para la acción si es necesario --}}
                                                </td>
                                            </tr>
                                        @endforeach

                                        {{-- Validaciones de cartas --}}
                                        @foreach ($cartas_validaciones as $validacion)
                                            <tr>
                                                <td>Carta para la Autorización de Uso de Firma Digital</td>
                                                <td>{{ ucfirst($validacion->estado) }}</td>
                                                <td>{{ $validacion->comentario }}</td>
                                                <td>
                                                    {{-- Lógica para la acción si es necesario --}}
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if ($fichas_validaciones->isEmpty() && $cartas_validaciones->isEmpty())
                                            <tr>
                                                <td colspan="4">No hay validaciones disponibles</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Mostrar documentos para subir --}}
                @if ($carta_validada && $ficha_validada)
                    {{ dd($ficha_registro, $carta_firma, $ficha_validada, $carta_validada) }}
                    <div class="card">
                        <div class="alert alert-secondary shadow-sm mt-4" role="alert">
                            Descarga los formatos de los documentos y adáptalos a tus necesidades, luego súbelos para su
                            revisión y aprobación.
                        </div>
                        <div class="card mt-4 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-header text-primary font-weight-bold">
                                    Evidencias Para Subir
                                </h6>
                                <div class="table-responsive">
                                    <table class="table table-bordered mt-3">
                                        <thead>
                                            <tr>
                                                <th>Documento</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Mostrar la ficha --}}
                                            <tr>
                                                <td>Ficha</td>
                                                <td>
                                                    {{ $ficha_registro ? ($ficha_registro->validada ? 'Validada' : 'No validada') : 'No disponible' }}
                                                </td>
                                                <td>
                                                    @if ($ficha_registro)
                                                        <a href="{{ Storage::url($ficha_registro->file_path) }}"
                                                            target="_blank" class="btn btn-primary btn-sm shadow-sm">Ver</a>
                                                        <a href="{{ route('document.download', $ficha_registro->id) }}"
                                                            class="btn btn-danger btn-sm shadow-sm">Descargar</a>
                                                    @endif
                                                </td>
                                            </tr>

                                            {{-- Mostrar la carta --}}
                                            <tr>
                                                <td>Carta</td>
                                                <td>
                                                    {{ $carta_firma ? ($carta_firma->validada ? 'Validada' : 'No validada') : 'No disponible' }}
                                                </td>
                                                <td>
                                                    @if ($carta_firma)
                                                        <a href="{{ Storage::url($carta_firma->file_path) }}"
                                                            target="_blank" class="btn btn-primary btn-sm shadow-sm">Ver</a>
                                                        <a href="{{ route('document.download', $carta_firma->id) }}"
                                                            class="btn btn-danger btn-sm shadow-sm">Descargar</a>
                                                    @endif
                                                </td>
                                            </tr>

                                            @if (!$ficha_registro && !$carta_firma)
                                                <tr>
                                                    <td colspan="3">No se han subido la ficha y la carta.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Mostrar evidencias subidas --}}
                    <div class="card mt-4 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-header text-primary font-weight-bold">Evidencias Subidas</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered mt-3">
                                    <thead>
                                        <tr>
                                            <th>Documento</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($evidencias as $evidencia)
                                            {{-- Filtrar para mostrar solo documentos válidos --}}
                                            @if ($evidencia->documento_id)
                                                <tr>
                                                    <td>{{ optional($evidencia->documento)->name }}</td>
                                                    <td>{{ $evidencia->estado }}</td>
                                                    <td>
                                                        <a href="{{ Storage::url($evidencia->file_path) }}" target="_blank"
                                                            class="btn btn-primary btn-sm shadow-sm">Ver</a>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @if ($evidencias->isEmpty())
                        <div class="alert alert-info shadow-sm mt-4" role="alert">
                            Aún no tienes evidencias subidas, sube tus evidencias para su respectiva revisión y aprobación.
                        </div>
                    @endif
                @endif
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
