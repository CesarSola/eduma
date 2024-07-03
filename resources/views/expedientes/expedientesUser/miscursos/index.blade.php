@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div class="text-center text-white bg-success p-3 rounded" style="width: 300px;">
            <h1 style="font-size: 1.5rem; margin-bottom: 0;">Mis Cursos</h1>
        </div>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div class="col-md-12 mb-8">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title mb-0">
                    Cursos inscritas por {{ $usuario->name }}
                </h6>
            </div>
        </div>
    </div>
    <div class="container mt-4">
        <div class="container">
            @if ($cursos->isEmpty())
                <div class="alert alert-primary" role="alert">
                    No tienes cursos inscritos.
                    <a class="btn btn-primary" href="{{ route('registroCurso.index') }}">Ir a la pestaña de inscripción a un
                        curso</a>
                </div>
            @else
                <ul class="list-group">
                    @foreach ($cursos as $curso)
                        @php
                            $validacionComentario = $curso
                                ->validacionesComentarios()
                                ->where('tipo_documento', 'comprobante_pago')
                                ->first();
                            if ($validacionComentario) {
                                $estado = $validacionComentario->tipo_validacion;
                            } else {
                                $estado = null;
                            }
                        @endphp
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span style="font-weight: bold; color: #333;">{{ $curso->name }}</span> -
                                {{ $curso->tipo }}
                                @if ($estado == 'validar')
                                    <a href="{{ route('evidenciasCU.index', ['id' => $curso->id, 'name' => $curso->name]) }}"
                                        class="btn btn-primary btn-sm ml-2">Ver</a>
                                @elseif ($estado == 'rechazar')
                                    <a href="{{ route('misCursos.resubir_comprobante', ['id' => $curso->id]) }}"
                                        class="btn btn-danger btn-sm ml-2">
                                        Resubir Comprobante
                                    </a>
                                @else
                                    <span class="badge badge-warning">En validación</span>
                                @endif
                            </div>
                            @if ($estado == 'validar')
                                <span class="badge badge-success badge-pill">Inscrito</span>
                            @elseif ($estado == 'rechazar')
                                <span class="badge badge-danger badge-pill">Comprobante: Rechazado</span>
                            @else
                                <span class="badge badge-warning badge-pill">Comprobante: Subido</span>
                            @endif
                        </li>
                    @endforeach

                </ul>
            @endif
        </div>
    </div>
@stop

@section('css')
    <style>
        /* Estilos personalizados aquí */
    </style>
@stop

@section('js')
    <!-- Incluir jQuery (si no está incluido ya) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        // Función para recargar la sección cada 5 minutos
        setInterval(function() {
            $.ajax({
                url: window.location.href, // URL actual, puede ser ajustada según necesidad
                type: 'GET', // Método de solicitud GET
                dataType: 'html', // Tipo de datos esperado (html en este caso)
                success: function(response) {
                    // Actualizar el contenido de la sección específica
                    var updatedContent = $(response).find('#id_del_contenedor_a_actualizar');
                    $('#id_del_contenedor_a_actualizar').html(updatedContent.html());
                }
            });
        }, 10000); // 300000 milisegundos = 5 minutos
    </script>
@stop
