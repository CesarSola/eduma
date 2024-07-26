@extends('adminlte::page')

@section('title', 'Validación de Documentos')

@section('content_header')
    <div class="header-flex">
        <h1>Revisión de Documento</h1>
        <div>
            <a href="{{ route('evidenciasACO.index', ['user_id' => $usuario->id, 'competencia' => $competencia->id]) }}"
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
                                            <h6 class="text-left mt-2">Apellidos: {{ $usuario->paternalSurname }}
                                                {{ $usuario->maternalSurname }}</h6>
                                            <h6 class="text-left mt-2">Edad: {{ $usuario->age }} años</h6>
                                        </div>
                                        <div class="right-content">
                                            <span class="badge badge-info">Estatus: Activo</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @php
                            $documentosParaRevisar = false;
                        @endphp

                        @foreach ($documentos as $documento)
                            @php
                                $estado = json_decode($documento->estado, true) ?? [];
                            @endphp
                            @if ($documento->file_path && (!isset($estado[$documento->nombre]) || $estado[$documento->nombre] == 'pendiente'))
                                @php
                                    $documentosParaRevisar = true;
                                @endphp
                                <form class="update-form"
                                    data-url="{{ route('ValidarDocumento.updateDocumento', ['id' => $usuario->id, 'competencia_id' => $documento->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-2 col-form-label">{{ ucfirst(str_replace('_', ' ', $documento->nombre)) }}</label>
                                        <div class="col-sm-4">
                                            <a href="{{ Storage::url($documento->file_path) }}" target="_blank"
                                                class="btn btn-primary">Ver</a>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="documento_estado"
                                                    id="validar_{{ $documento->nombre }}" value="validar">
                                                <label class="form-check-label"
                                                    for="validar_{{ $documento->nombre }}">Validar</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="documento_estado"
                                                    id="rechazar_{{ $documento->nombre }}" value="rechazar">
                                                <label class="form-check-label"
                                                    for="rechazar_{{ $documento->nombre }}">Rechazar</label>
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
                            const successMessage = document.getElementById('success-message');
                            if (data.success) {
                                successMessage.style.display = 'block';

                                // Ocultar el mensaje después de 3 segundos
                                setTimeout(() => {
                                    successMessage.style.display = 'none';
                                }, 3000);

                                const action = formData.get('documento_estado');
                                if (action === 'validar') {
                                    form.closest('.update-form').style.display =
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
                                } else {
                                    form.closest('.update-form').style.display =
                                    'none'; // Ocultar el formulario del documento rechazado
                                    if (!document.querySelector('.update-form')) {
                                        document.querySelector('.card-header').innerHTML += `
                                        <div class="form-group row">
                                            <div class="col-sm-12 text-center">
                                                <p>Todos los documentos disponibles han sido validados.</p>
                                            </div>
                                        </div>
                                    `;
                                    }
                                }
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@stop
