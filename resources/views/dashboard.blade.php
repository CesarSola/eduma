@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Gestión de cursos y EC Laravel 11.</p>
    <p>Prueba dos ded Git</p>

    <div class="card">
        <div class="card-body">
            <a href="{{ route('roles.index') }}" class="btn btn-primary">Ver Roles</a>
        </div>
    </div>

    @if(Auth::user()->hasRole('Admin'))
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
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Verifica si el gráfico debe ser mostrado
            @if(Auth::user()->hasRole('Admin'))
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
