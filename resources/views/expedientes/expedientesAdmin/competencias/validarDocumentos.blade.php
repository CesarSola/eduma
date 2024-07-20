@extends('adminlte::page')

@section('content_header')
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Validar Documentos</h1>
                <a href="{{ route('evidenciasACO.index', ['user_id' => $usuario->id, 'competencia' => $competencia]) }}"
                    class="btn btn-secondary">Regresar</a>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="container mt-4">
        @if ($documentos->isEmpty())
            <div class="text-center">
                <p>No hay documentos para validar en esta competencia.</p>
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>Documentos para Validar</h3>

                            @foreach ($documentos as $documento)
                                <div class="documento">
                                    <form class="update-form"
                                        data-url="{{ route('evidenciasACO.updateDocumento', ['id' => $usuario->id, 'documentoId' => $documento->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Documento</label>
                                            <div class="col-sm-6">
                                                <span>{{ $documento->nombre }}</span>
                                            </div>
                                            <div class="col-sm-3">
                                                <a href="{{ Storage::url($documento->file_path) }}" target="_blank"
                                                    class="btn btn-info btn-sm shadow">Ver Documento</a>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Estado del Documento</label>
                                            <div class="col-sm-6">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="documento_estado"
                                                        id="validar_documento_{{ $documento->id }}" value="validar">
                                                    <label class="form-check-label"
                                                        for="validar_documento_{{ $documento->id }}">Validar</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="documento_estado"
                                                        id="rechazar_documento_{{ $documento->id }}" value="rechazar">
                                                    <label class="form-check-label"
                                                        for="rechazar_documento_{{ $documento->id }}">Rechazar</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="submit"
                                                    class="btn btn-success btn-sm shadow-sm">Actualizar</button>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Comentarios</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" name="comentario_documento" placeholder="Agregar comentarios"></textarea>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@stop

@section('css')
    <style>
        /* Puedes agregar estilos personalizados aquí si es necesario */
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
                                document.getElementById('success-message').style.display =
                                    'block';

                                // Actualizar el mensaje según la acción (validar/rechazar)
                                const action = formData.get('documento_estado');
                                if (action === 'validar') {
                                    form.closest('.update-form').style.display =
                                        'none'; // Ocultar el formulario validado
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
                                    // Resetear campos de validar y comentario
                                    form.querySelector('input[type="radio"]:checked').checked =
                                        false; // Deseleccionar el radio button seleccionado
                                    form.querySelector('textarea[name="comentario_documento"]')
                                        .value = ''; // Reiniciar el campo de comentarios

                                    // Mostrar mensaje de documento rechazado
                                    const messageElement = form.querySelector(
                                        '.alert.alert-info');
                                    if (messageElement) {
                                        messageElement.style.display = 'block';
                                    }

                                    // Cambiar texto del botón
                                    form.querySelector('.btn.btn-success').innerText =
                                        'Volver a validar';
                                }
                            } else if (data.error) {
                                alert(data.error); // Manejar errores si es necesario
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@stop
