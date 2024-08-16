@extends('adminlte::page')

@section('title', 'Validación de Carta')

@section('content_header')
    <div class="header-flex">
        <h1>Revisión de Carta</h1>
        <div>
            <a href="{{ route('evidenciasACO.index', ['user_id' => $usuario->id, 'competencia' => $competencia]) }}"
                class="btn btn-secondary">Regresar</a>
        </div>
    </div>
@stop

@section('content')

    <div class="container">
        <div id="success-message" class="alert alert-success" style="display: none;">
            Documento actualizado correctamente.
            <button type="button" class="close" aria-label="Close" onclick="this.parentElement.style.display='none';">
                <span aria-hidden="true">&times;</span>
            </button>
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
                                            <h6 class="text-left mt-2">Nombres: {{ $usuario->name }}
                                                {{ $usuario->secondName }}</h6>
                                            <h6 class="text-left mt-2">Apellidos:
                                                {{ $usuario->paternalSurname }}
                                                {{ $usuario->maternalSurname }}</h6>
                                            <h6 class="text-left mt-2">Edad: {{ $usuario->age }} años</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php
                            $documentosParaRevisar = false;
                        @endphp

                        <!-- Mostrar documentos específicos -->
                        @foreach ($cartasDocumentos as $carta)
                            @php
                                $estado = json_decode($carta->estado, true) ?? [];
                            @endphp
                            @if ($carta->file_path && (!isset($estado['estado']) || $estado['estado'] == 'rechazar'))
                                @php
                                    $documentosParaRevisar = true;
                                @endphp
                                <form class="update-form"
                                    data-url="{{ route('ValidarCarta.updateDocumento', ['id' => $usuario->id, 'cartaId' => $carta->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-2 col-form-label">{{ ucfirst(str_replace('_', ' ', $carta->nombre)) }}</label>
                                        <div class="col-sm-4">
                                            <a href="{{ Storage::url($carta->file_path) }}" target="_blank"
                                                class="btn btn-primary">Ver</a>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="documento_estado"
                                                    id="validar_{{ $carta->nombre }}" value="validar">
                                                <label class="form-check-label"
                                                    for="validar_{{ $carta->nombre }}">Validar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="documento_estado"
                                                    id="rechazar_{{ $carta->nombre }}" value="rechazar">
                                                <label class="form-check-label"
                                                    for="rechazar_{{ $carta->nombre }}">Rechazar</label>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: 'Documento actualizado correctamente.',
                                    showConfirmButton: true, // Mostrar el botón de cierre
                                    confirmButtonText: 'Cerrar', // Texto del botón
                                });

                                const action = formData.get('documento_estado');
                                if (action === 'validar') {
                                    form.closest('.update-form').style.display = 'none';

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
                                    form.querySelector('input[type="radio"]:checked').checked =
                                        false;
                                    form.querySelector('textarea[name="comentario_documento"]')
                                        .value = '';
                                    form.querySelector('.btn.btn-success').innerText =
                                        'Volver a validar';
                                }
                            } else if (data.error) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: data.error,
                                    showConfirmButton: true, // Mostrar el botón de cierre
                                    confirmButtonText: 'Cerrar', // Texto del botón
                                });
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@stop
