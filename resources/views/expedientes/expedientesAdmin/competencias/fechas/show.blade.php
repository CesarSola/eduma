@extends('adminlte::page')

@section('title', 'Fechas Disponibles y Elegidas')

@section('content_header')
    <h1>Fechas Disponibles y Elegidas</h1>
    <a href="{{ route('competencia.index', ['user_id' => request()->query('user_id')]) }}"
        class="btn btn-secondary mt-3">Regresar</a>

    <!-- Botón para abrir el modal -->
    <button class="btn btn-primary mt-3" data-toggle="modal" data-target="#modalAgregarFechas">Agregar Fechas</button>
    </button>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <div id='calendar'></div>
        </div>
        @include('expedientes.expedientesAdmin.competencias.fechas.agregar-fechas');
    </div>

    <!-- Modal para Fechas Dadas por Administradores -->
    <div class="modal fade" id="availableDateModal" tabindex="-1" aria-labelledby="availableDateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="availableDateModalLabel">Detalles de la Fecha Dada por Administradores</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Estándar:</strong> <span id="availableEventStandard"></span></p>
                    <p><strong>Fecha:</strong> <span id="availableEventDate"></span></p>
                    <p><strong>Horarios:</strong> <span id="availableEventHours"></span></p>
                    <p><strong>Usuario:</strong> <span id="availableEventUser"></span></p> <!-- Añade esta línea -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal para Fechas Elegidas -->
    <div class="modal fade" id="selectedDateModal" tabindex="-1" aria-labelledby="selectedDateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectedDateModalLabel">Detalles de la Fecha Elegida</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Estándar:</strong> <span id="selectedEventStandard"></span></p>
                    <p><strong>Usuario:</strong> <span id="selectedEventUser"></span></p>
                    <p><strong>Fecha:</strong> <span id="selectedEventDate"></span></p>
                    <p><strong>Horarios:</strong> <span id="selectedEventHours"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <style>
        .fc-event {
            border-radius: 4px;
            padding: 10px;
            font-size: 14px;
        }

        .fc-event.available {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            color: #fff !important;
        }

        .fc-event.selected {
            background-color: #007bff !important;
            border-color: #007bff !important;
            color: #fff !important;
        }

        .fc-daygrid-day-number {
            font-size: 16px;
            color: #333;
        }

        .fc-daygrid-day-top {
            background-color: #f7f7f7;
            border: 1px solid #ddd;
        }

        .fc-event-title {
            font-size: 14px;
        }

        .fc-daygrid-day-top.fc-day-today {
            background-color: #e9ecef;
        }

        .fc-daygrid-day-top.fc-day-other-month {
            color: #6c757d;
        }
    </style>
@stop

@section('js')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'es',
                events: [
                    @foreach ($fechasDisponibles as $fecha)
                        {
                            title: 'Fecha Dada por los Administradores',
                            start: '{{ $fecha->fecha->format('Y-m-d') }}',
                            classNames: ['available'],
                            extendedProps: {
                                estandar: '{{ $fecha->competencia->name }}',
                                fecha: '{{ $fecha->fecha->format('d/m/Y') }}',
                                horarios: '{{ $fecha->horarios->pluck('hora')->implode(', ') }}',
                                user: '{{ $fecha->user->name }} {{ $fecha->user->secondName }} {{ $fecha->user->paternalSurname }} {{ $fecha->user->maternalSurname }}',
                                tipo: 'disponible'
                            }
                        },
                    @endforeach
                    @foreach ($fechasElegidas as $fechaElegida)
                        {
                            title: 'Fecha Elegida por {{ $fechaElegida->user->name }}',
                            start: '{{ $fechaElegida->fechaCompetencia->fecha->format('Y-m-d') }}',
                            classNames: ['selected'],
                            extendedProps: {
                                estandar: '{{ $fechaElegida->fechaCompetencia->competencia->name }}',
                                usuario: '{{ $fechaElegida->user->name }} {{ $fechaElegida->user->secondName }} {{ $fechaElegida->user->paternalSurname }} {{ $fechaElegida->user->maternalSurname }}',
                                fecha: '{{ $fechaElegida->fechaCompetencia->fecha->format('d/m/Y') }}',
                                horarios: '{{ $fechaElegida->horarioCompetencia->hora }}',
                                tipo: 'elegida'
                            }
                        },
                    @endforeach
                ],
                eventClick: function(info) {
                    if (info.event.extendedProps.tipo === 'disponible') {
                        document.getElementById('availableEventStandard').innerText = info.event
                            .extendedProps.estandar;
                        document.getElementById('availableEventDate').innerText = info.event
                            .extendedProps.fecha;
                        document.getElementById('availableEventHours').innerText = info.event
                            .extendedProps.horarios;
                        document.getElementById('availableEventUser').innerText = info.event
                            .extendedProps.user;
                        var availableDateModal = new bootstrap.Modal(document.getElementById(
                            'availableDateModal'));
                        availableDateModal.show();
                    } else if (info.event.extendedProps.tipo === 'elegida') {
                        document.getElementById('selectedEventStandard').innerText = info.event
                            .extendedProps.estandar;
                        document.getElementById('selectedEventUser').innerText = info.event
                            .extendedProps.usuario;
                        document.getElementById('selectedEventDate').innerText = info.event
                            .extendedProps.fecha;
                        document.getElementById('selectedEventHours').innerText = info.event
                            .extendedProps.horarios;
                        var selectedDateModal = new bootstrap.Modal(document.getElementById(
                            'selectedDateModal'));
                        selectedDateModal.show();
                    }
                }
            });
            calendar.render();
        });
    </script>




@stop
