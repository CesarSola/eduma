@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="card modern-card">
        <div class="card-body">
            <div class="left-content">
                <div class="text-center">
                    <p class="sice-text">S.I.C.E.</p>
                    <p class="sice-text">Sistema Innovador de Centro Evaluador</p>
                </div>
            </div>
        </div>
    </div>


@stop

@section('content')
    <div id="1">
        <div class="card modern-card">
            <div class="card-header text-center">
                <h4 class="card-title">Bienvenido</h4>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <!-- Foto del usuario -->
                    <div class="profile-picture">
                        <img src="{{ $usuario->foto }}" alt="Profile Picture" class="img-fluid rounded-circle"
                            onerror="this.src='{{ asset('assets/profile-default/profile_default.jpeg') }}';">
                    </div>
                    <!-- Información del usuario -->
                    <div class="ml-3">
                        <h6 class="user-name">
                            {{ $usuario->name }} {{ $usuario->secondName }} {{ $usuario->paternalSurname }}
                            {{ $usuario->maternalSurname }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <br>
        @php
            $documentosSubidos = !$documentos->isEmpty();
            $todosDocumentosValidados = $documentos->isEmpty()
                ? false
                : $documentos->every(function ($documento) {
                    $estado = json_decode($documento->estado, true) ?? [];
                    foreach (['foto', 'ine_ife', 'comprobante_domiciliario', 'curp'] as $tipo_documento) {
                        if (!isset($estado[$tipo_documento]) || $estado[$tipo_documento] !== 'validar') {
                            return false;
                        }
                    }
                    return true;
                });
        @endphp

        @if (!$documentosSubidos)
            <!-- Tarjeta principal que se despliega al hacer clic -->
            <div class="card">
                <h6 style="text-align: center" class="card-title toggle-card" data-target="#requerimientos-container">
                    Lista de requerimientos y documentación
                </h6>
                <br>
                <div class="card d-none" id="requerimientos-container">
                    <div class="card-body">
                        <!-- Tarjetas independientes -->
                        <div class="card custom-card" id="fotografia-card">
                            <div class="card-header">
                                <h5 class="card-title">Fotografía</h5>
                            </div>
                            <div class="card-body d-none">
                                Tamaño infantil 2.5 cm x 3 cm (94.50 x 113.4 pixeles), de frente a color con fondo blanco,
                                sin sombras y sin lentes. Peso máximo de 300 Kb y formato JPG, BMP o PNG. Se recomienda
                                acudir a un estudio fotográfico.
                            </div>
                        </div>
                        <div class="card custom-card" id="ine-card">
                            <div class="card-header">
                                <h5 class="card-title">INE</h5>
                            </div>
                            <div class="card-body d-none">
                                Identificación oficial escaneada INE o IFE, que sea legible.
                            </div>
                        </div>
                        <div class="card custom-card" id="comprobante-card">
                            <div class="card-header">
                                <h5 class="card-title">Comprobante Domiciliario</h5>
                            </div>
                            <div class="card-body d-none">
                                Comprobante domiciliario actual y escaneado de forma legible en PDF.
                            </div>
                        </div>
                        <div class="card custom-card" id="curp-card">
                            <div class="card-header">
                                <h5 class="card-title">CURP</h5>
                            </div>
                            <div class="card-body d-none">
                                CURP en formato PDF escaneado y legible.
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="card modern-card text-center p-3">
                <h6 class="card-title">Sube tus documentos aquí</h6>
                <br>
                <!-- Botón para abrir el modal -->
                <button type="button" class="btn btn-success btn-sm mx-auto" data-toggle="modal"
                    data-target="#documentosModal">
                    Subir Documentos
                </button>
            </div>
        @elseif (!$todosDocumentosValidados)
            <div class="card modern-card">
                <h6 style="text-align: center" class="card-title">Documentos siendo validados</h6>
                <br>
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
                            @foreach ($documentos as $documento)
                                @php
                                    $estado = json_decode($documento->estado, true) ?? [];
                                @endphp
                                @foreach (['foto', 'ine_ife', 'comprobante_domiciliario', 'curp'] as $tipo_documento)
                                    @if ($documento->$tipo_documento)
                                        <tr>
                                            <td>{{ ucfirst(str_replace('_', ' ', $tipo_documento)) }}</td>
                                            <td>
                                                @if (isset($estado[$tipo_documento]))
                                                    @if ($estado[$tipo_documento] == 'validar')
                                                        Validado
                                                    @elseif ($estado[$tipo_documento] == 'rechazar')
                                                        Rechazado
                                                    @endif
                                                @else
                                                    En proceso
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $comentario = $documento->validacionesComentarios
                                                        ->where('tipo_documento', $tipo_documento)
                                                        ->first();
                                                @endphp
                                                {{ $comentario ? $comentario->comentario : '' }}
                                            </td>
                                            <td>
                                                @if (isset($estado[$tipo_documento]) && $estado[$tipo_documento] == 'rechazar')
                                                    <a href="{{ route('documentosUser.editByTipo', ['tipo_documento' => $tipo_documento]) }}"
                                                        class="btn btn-warning">Resubir</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <br>
            <div class="card">
                <h6 style="text-align: center" class="card-title">Estándares de Competencias</h6>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card modern-card">
                            <h6 style="text-align: center" class="card-title">Inscríbete a un EC</h6>
                            <br>
                            <div class="card-body text-center">
                                <a href="{{ route('competenciaEC.index') }}" class="btn btn-primary">Ver competencias</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card modern-card">
                            <h6 style="text-align: center" class="card-title">Mis Competencias</h6>
                            <br>
                            <div class="card-body text-center">
                                <a href="{{ route('miscompetencias.index') }}" class="btn btn-primary">Ver mis
                                    competencias</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <br>
            <div class="card">
                <h6 style="text-align: center" class="card-title">Cursos</h6>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card modern-card">
                            <h6 style="text-align: center" class="card-title">Inscríbete a un Curso</h6>
                            <br>
                            <div class="card-body text-center">
                                <a href="{{ route('registroCurso.index') }}" class="btn btn-primary">Ver Cursos</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card modern-card">
                            <h6 style="text-align: center" class="card-title">Mis Cursos</h6>
                            <br>
                            <div class="card-body text-center">
                                <a href="{{ route('misCursos.index') }}" class="btn btn-primary">Ver mis cursos</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
    @include('expedientes.expedientesUser.documentosUser.index')
@stop

@section('css')
    <style>
        /* Estilos para la tarjeta moderna */
        .modern-card {
            border: none;
            border-radius: 12px;
            /* Esquinas más redondeadas */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            /* Sombra más sutil */
            background-color: #ffffff;
            margin-bottom: 20px;
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            /* Añadido transform */
        }

        .modern-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            /* Sombra más pronunciada en hover */
            transform: translateY(-5px);
            /* Elevación sutil en hover */
        }

        .card-header {
            background-color: #5cb85c;
            /* Color de fondo del header */
            color: #ffffff;
            /* Color del texto del header */
            padding: 15px;
            border-radius: 12px 12px 0 0;
            /* Esquinas redondeadas solo en la parte superior */
            font-size: 1.25rem;
            /* Tamaño de fuente para card-title */
            font-weight: 500;
            /* Peso de fuente más ligero */
            text-align: center;
            /* Centrar texto */
        }

        .card-body {
            background-color: #f1f9f0;
            /* Color de fondo más claro y neutro */
            padding: 20px;
            border: 1px solid #d0e1d4;
            /* Borde más sutil */
            border-radius: 0 0 12px 12px;
            /* Esquinas redondeadas solo en la parte inferior */
        }

        .card-title {
            font-size: 1.25rem;
            /* Tamaño de fuente para card-title */
            font-weight: 500;
            /* Peso de fuente más ligero */
            color: #ffffff;
            /* Color del texto del título */
            background-color: #5cb85c;
            /* Color de fondo del título */
            padding: 10px 15px;
            /* Relleno para hacer más espacio alrededor del texto */
            border-radius: 6px;
            /* Esquinas más suaves */
            margin: 0;
            text-align: center;
            /* Centrar texto */
        }

        /* Añadir animación al h4 en card-header */
        .card-header .card-title {
            font-size: 2rem;
            /* Tamaño de fuente más grande para el h4 */
            animation: fadeInText 2s ease-in-out infinite alternate;
            /* Aplicar la animación al h4 */
        }

        .profile-picture {
            width: 80px;
            /* Aumento del tamaño para mejor visibilidad */
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #5cb85c;
            /* Borde más grueso */
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-right: 15px;
        }

        .profile-picture img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-name {
            font-size: 1.125rem;
            /* Tamaño de fuente para h6 */
            color: #ffffff;
            /* Color del texto de h6 */
            background-color: #5cb85c;
            /* Fondo del texto de h6 */
            padding: 8px 12px;
            /* Relleno para hacer más espacio alrededor del texto */
            border-radius: 6px;
            /* Esquinas más suaves */
            margin: 0;
            text-align: center;
            /* Centrar texto */
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        /* Estilo y animación para el texto de SICE */
        .sice-text {
            font-size: 2rem;
            /* Tamaño de fuente para SICE */
            font-weight: 700;
            /* Peso de fuente para SICE */
            color: #5cb85c;
            /* Color del texto */
            text-transform: uppercase;
            /* Transformación de texto a mayúsculas */
            animation: fadeInText 5s ease-in-out infinite alternate;
            /* Animación */
        }

        /* Definición de la animación */
        @keyframes fadeInText {
            0% {
                opacity: 0.98;
                transform: scale(0.98);
            }

            50% {
                opacity: 0.99;
                transform: scale(0.99);
            }

            100% {
                opacity: 1;
                transform: scale(1);
            }
        }
    </style>


@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const toggleCards = document.querySelectorAll('.toggle-card');
            const customCards = document.querySelectorAll('.custom-card');

            // Manejo del despliegue de la tarjeta principal
            toggleCards.forEach(function(card) {
                const targetId = card.getAttribute('data-target');
                const target = document.querySelector(targetId);

                // Cargar el estado desde localStorage
                const state = localStorage.getItem(targetId);
                if (state === 'open') {
                    target.classList.remove('d-none');
                } else {
                    target.classList.add('d-none');
                }

                card.addEventListener('click', function() {
                    target.classList.toggle('d-none');
                    // Guardar el estado en localStorage
                    if (target.classList.contains('d-none')) {
                        localStorage.setItem(targetId, 'closed');
                    } else {
                        localStorage.setItem(targetId, 'open');
                    }
                });
            });

            // Manejo del despliegue de las tarjetas individuales dentro de la tarjeta principal
            customCards.forEach(card => {
                const header = card.querySelector('.card-header');
                const body = card.querySelector('.card-body');

                header.addEventListener('click', function() {
                    body.classList.toggle('d-none');
                });
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'Aceptar'
                });
            @endif
        });
    </script>

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
        }, 120000); // 300000 milisegundos = 5 minutos
    </script>
@stop
