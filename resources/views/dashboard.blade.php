@extends('adminlte::page')

@section('title', 'Dashboard')

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
    {{--  <div class="card">
        <div class="card-body">
            <a href="{{ route('roles.index') }}" class="btn btn-primary">Ver Roles</a>
        </div>
    </div>  --}}

    @if (Auth::user()->hasRole('Admin'))
        <!-- Canvas para el gráfico -->
        <div class="card">
            <div class="card-body">
                <canvas id="myChart" width="400" height="200"></canvas>
            </div>
        </div>
    @endif
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="/css/admin_custom.css">
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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Verifica si el gráfico debe ser mostrado
            @if (Auth::user()->hasRole('Admin'))
                var ctx = document.getElementById('myChart').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['EC12', 'EC123', 'EC221', 'EC1245', 'EC453', 'EC121'],
                        datasets: [{
                            label: '# of users',
                            data: [12, 19, 3, 5, 2, 3],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            @endif
        });
    </script>
@stop
