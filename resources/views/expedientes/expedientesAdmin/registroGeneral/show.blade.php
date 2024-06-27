@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Revisión de Documentos Generales</h1>
        <a href="{{ route('usuariosAdmin.show', ['usuariosAdmin' => $registroGeneral->id]) }}"
            class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div class="container">
        <div id="success-message" class="alert alert-success alert-dismissible" style="display: none;">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            Documento actualizado correctamente.
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body header-flex">
                                        <div class="left-content">
                                            <div class="text-center">
                                                <img src="{{ asset('path_to_default_avatar') }}" alt=""
                                                    class="img-circle">
                                            </div>
                                            <h6 class="text-left mt-2">Nombres: {{ $registroGeneral->name }}
                                                {{ $registroGeneral->secondName }}</h6>
                                            <h6 class="text-left mt-2">Apellidos: {{ $registroGeneral->paternalSurname }}
                                                {{ $registroGeneral->maternalSurname }}</h6>
                                            <h6 class="text-left mt-2">Edad: {{ $registroGeneral->age }} años</h6>
                                        </div>
                                        <div class="right-content">
                                            <span class="badge badge-info">Estatus: Activo</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        @php
                            $documentosParaRevisar = false;
                        @endphp

                        <!-- Mostrar documentos específicos -->
                        @foreach ($documentos as $documento)
                            @foreach (['foto', 'ine_ife', 'comprobante_domiciliario', 'curp'] as $documentoNombre)
                                @php
                                    $estado = json_decode($documento->estado, true) ?? [];
                                @endphp
                                @if ($documento->$documentoNombre && (!isset($estado[$documentoNombre]) || $estado[$documentoNombre] == 'rechazar'))
                                    @php
                                        $documentosParaRevisar = true;
                                    @endphp
                                    <form class="update-form"
                                        data-url="{{ route('registroGeneral.updateDocumento', ['id' => $registroGeneral->id, 'documento' => $documentoNombre]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label
                                                class="col-sm-2 col-form-label">{{ ucfirst(str_replace('_', ' ', $documentoNombre)) }}</label>
                                            <div class="col-sm-4">
                                                <a href="{{ Storage::url($documento->$documentoNombre) }}" target="_blank"
                                                    class="btn btn-primary">Ver</a>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="documento_estado"
                                                        id="validar_{{ $documentoNombre }}" value="validar">
                                                    <label class="form-check-label"
                                                        for="validar_{{ $documentoNombre }}">Validar</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="documento_estado"
                                                        id="rechazar_{{ $documentoNombre }}" value="rechazar">
                                                    <label class="form-check-label"
                                                        for="rechazar_{{ $documentoNombre }}">Rechazar</label>
                                                </div>
                                                <textarea class="form-control mt-2" name="comentario_documento" placeholder="Agregar comentarios"></textarea>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="submit" class="btn btn-success">Listo</button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            @endforeach
                        @endforeach
                        <!-- Mensaje para documentos validados -->
                        @if (!$documentosParaRevisar)
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class="col-sm-12 text-center">
                                            <p>Todos los documentos disponibles han sido validados.</p>
                                        </div>
                                    </div>
                                </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('css')
    <style>
        .header-flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .left-content {
            width: 70%;
        }

        .right-content {
            width: 30%;
            text-align: right;
        }

        .card-title {
            background-color: #067dd2;
            text-align: center;
            width: 100%;
            color: white;
            border-radius: 5px;
        }

        .card-body {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #5cb8a9;
            border-radius: 5px;
        }

        .list-group-item {
            text-align: center;
            width: 100%;
        }

        .h-100 {
            height: 100%;
        }

        .overflow-auto {
            max-height: 200px;
            /* Ajusta esta altura según sea necesario */
            overflow-y: auto;
        }

        .btn-secondary {
            margin-left: auto;
        }

        .btn-success {
            align-content: center;
            width: 50%;
        }

        .btn-primary {
            width: 100%;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
        }

        .toggle-card {
            cursor: pointer;
        }
    </style>
@stop


@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.update-form');
            const successMessage = document.getElementById('success-message');
            const closeButton = successMessage.querySelector('.close');

            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(form);
                    const url = form.getAttribute('data-url');

                    fetch(url, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: formData
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                successMessage.style.display = 'block';

                                // Actualizar el mensaje según la acción (validar/rechazar)
                                const action = formData.get('documento_estado');
                                if (action === 'validar') {
                                    form.style.display =
                                        'none'; // Ocultar el formulario del documento validado
                                    if (!document.querySelector('.update-form')) {
                                        document.querySelector('.card-header').innerHTML += `
                                            <div class="form-group row">
                                                <div class="col-sm-12 text-center">
                                                    <p>Todos los documentos disponibles han sido validados.</p>
                                                </div>
                                            </div>
                                        `;
                                    }
                                } else if (action === 'rechazar') {
                                    // Dejar el formulario visible, pero limpiar los campos
                                    form.querySelector('textarea[name="comentario_documento"]')
                                        .value = ''; // Limpiar el campo de comentarios
                                    form.querySelectorAll('input[type="radio"]').forEach(
                                        radio => radio.checked = false
                                    ); // Deseleccionar todos los radio buttons
                                }

                                // Ocultar el mensaje de éxito después de 5 segundos
                                setTimeout(() => {
                                    successMessage.style.display = 'none';
                                }, 5000);
                            } else if (data.error) {
                                alert(data.error); // Manejar errores si es necesario
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });

            // Agregar evento al botón de cerrar
            closeButton.addEventListener('click', function() {
                successMessage.style.display = 'none';
            });
        });
    </script>
@stop
