@extends('adminlte::page')

@section('title', 'Expediente')

@section('content_header')
    <div class="header-flex">
        <h1>Revisión de Documentos Generales</h1>
        <div>
            <a href="{{ route('usuariosAdmin.show', ['usuariosAdmin' => $registroGeneral->id]) }}"
                class="btn btn-secondary">Regresar</a>
        </div>
    </div>
@stop

@section('content')

    <div class="container">
        <div id="success-message" class="alert alert-success" style="display: none;">
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
                                            <h6 class="text-left mt-2">Apellidos:
                                                {{ $registroGeneral->paternalSurname }}
                                                {{ $registroGeneral->maternalSurname }}</h6>
                                            <h6 class="text-left mt-2">Edad: {{ $registroGeneral->age }} años</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

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
                            <div class="form-group row">
                                <div class="col-sm-12 text-center">
                                    <p>Todos los documentos disponibles han sido validados.</p>
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

        .content-flex {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .left-content {
            width: 50%;
            float: left;
        }

        .right-content {
            width: 50%;
            float: right;
            text-align: right;
        }

        .button-right {
            float: right;
        }
    </style>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forms = document.querySelectorAll('.update-form');
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
                                const action = formData.get('documento_estado');

                                // Mostrar SweetAlert2 para éxito de validación o rechazo
                                Swal.fire({
                                    icon: action === 'validar' ? 'success' : 'warning',
                                    title: action === 'validar' ? 'Documento Validado' :
                                        'Documento Rechazado',
                                    text: action === 'validar' ?
                                        'Documento validado correctamente.' :
                                        'El documento ha sido rechazado.',
                                    showCancelButton: action === 'rechazar',
                                    confirmButtonText: action === 'validar' ?
                                        'Aceptar' : 'Volver a Validar',
                                    cancelButtonText: 'Cancelar'
                                }).then(result => {
                                    if (result.isConfirmed && action === 'rechazar') {
                                        // Acción si se confirma el rechazo (si es necesario)
                                    }

                                    // Actualizar el mensaje según la acción (validar/rechazar)
                                    if (action === 'validar') {
                                        form.closest('.update-form').style.display =
                                            'none';

                                        // Verificar si todos los documentos han sido validados
                                        const remainingForms = document
                                            .querySelectorAll('.update-form');
                                        if (remainingForms.length === 0) {
                                            // Mostrar el mensaje de todos los documentos validados
                                            Swal.fire({
                                                icon: 'info',
                                                title: 'Todos los Documentos Validados',
                                                text: 'Todos los documentos disponibles han sido validados.',
                                                showConfirmButton: false,
                                                timer: 1500
                                            }).then(() => {
                                                // Actualizar el DOM para mostrar el mensaje final
                                                const cardHeader = document
                                                    .querySelector(
                                                        '.card-header');
                                                if (cardHeader) {
                                                    cardHeader.innerHTML += `
                                                        <div class="form-group row">
                                                            <div class="col-sm-12 text-center">
                                                                <p>Todos los documentos disponibles han sido validados.</p>
                                                            </div>
                                                        </div>
                                                    `;
                                                }
                                            });
                                        }
                                    } else if (action === 'rechazar') {
                                        // Resetear campos de validar y comentario
                                        form.querySelector(
                                                'input[type="radio"]:checked').checked =
                                            false; // Deseleccionar el radio button seleccionado
                                        form.querySelector(
                                                'textarea[name="comentario_documento"]')
                                            .value =
                                            ''; // Reiniciar el campo de comentarios

                                        // Mostrar mensaje de documento rechazado
                                        Swal.fire({
                                            icon: 'warning',
                                            title: 'Documento Rechazado',
                                            text: 'El documento ha sido rechazado. Puedes volver a validar.',
                                            showCancelButton: true,
                                            confirmButtonText: 'Aceptar',
                                            cancelButtonText: 'Cancelar'
                                        }).then(result => {
                                            if (result.isConfirmed) {
                                                // Acción si se confirma el rechazo (si es necesario)
                                            }
                                        });

                                        // Cambiar texto del botón
                                        form.querySelector('.btn.btn-success')
                                            .innerText = 'Volver a Validar';
                                    }
                                });
                            } else if (data.error) {
                                // Mostrar SweetAlert2 para error
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.error
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Ocurrió un error inesperado.'
                            });
                        });
                });
            });
        });
    </script>
@stop
