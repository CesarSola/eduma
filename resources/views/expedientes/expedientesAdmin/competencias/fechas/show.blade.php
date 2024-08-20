@extends('adminlte::page')

@section('title', 'Fechas Disponibles y Elegidas')

@section('content_header')
    <h1>Fechas Disponibles y Elegidas</h1>
    <a href="{{ route('calendario.index', ['user_id' => request()->query('user_id')]) }}"
        class="btn btn-secondary mt-3">Regresar</a>

@stop

@section('content')
    <div class="search-container d-flex justify-content-center align-items-center my-3">
        <input type="date" id="datePicker" class="form-control me-2 shadow-sm" style="max-width: 200px;" />
        <button id="goToDateButton" class="btn btn-primary shadow-sm">
            <i class="fas fa-calendar-alt me-1"></i> Ir a Fecha
        </button>
    </div>


    <div id='calendar'></div>

    <!-- Modal para Fecha Dada por Administradores -->
    <div class="modal fade" id="availableDateModal" tabindex="-1" aria-labelledby="availableDateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="availableDateModalLabel">Detalles de la Fecha Dada por Administradores</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p><strong>Estándar:</strong> <span id="availableEventStandard" class="badge bg-secondary"></span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Fecha:</strong> <span id="availableEventDate" class="badge bg-info text-dark"></span></p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Horarios:</strong> <span id="availableEventHours"
                                class="badge bg-warning text-dark"></span></p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Evaluador:</strong> <span id="availableEventUser" class="badge bg-success"></span></p>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Fecha Elegida -->
    <div class="modal fade" id="selectedDateModal" tabindex="-1" aria-labelledby="selectedDateModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="selectedDateModalLabel">Detalles de la Fecha Elegida</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <p><strong>Estándar:</strong> <span id="selectedEventStandard" class="badge bg-secondary"></span>
                        </p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Fecha:</strong> <span id="selectedEventDate" class="badge bg-info text-dark"></span></p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Horarios:</strong> <span id="selectedEventHours"
                                class="badge bg-warning text-dark"></span></p>
                    </div>
                    <div class="mb-3">
                        <p><strong>Evaluador:</strong> <span id="selectedEventUser" class="badge bg-primary"></span></p>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>


@stop

@section('css')
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <!-- Incluye FontAwesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* Estilos generales para el calendario */
        #calendar {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        /* Estilos para los eventos del calendario */
        .fc-event {
            padding: 10px 15px;
            font-size: 14px;
            border-radius: 12px;
            display: block;
            white-space: normal;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
            height: auto;
            box-sizing: border-box;
            word-wrap: break-word;
            color: #fff;
            font-weight: bold;
            text-align: center;
            transition: all 0.3s ease;
        }

        /* Estilo para eventos disponibles */
        .fc-event.available {
            background-color: #28a745 !important;
            border: 1px solid #228636;
        }

        /* Estilo para eventos seleccionados */
        .fc-event.selected {
            background-color: #007bff !important;
            border: 1px solid #0056b3;
        }

        /* Estilo para eventos destacados */
        .fc-event.highlighted {
            border: none;
            background-color: transparent;
            position: relative;
        }

        .fc-event.highlighted::before {
            content: '';
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: #ff0000;
            box-shadow: 0 0 6px rgba(0, 0, 0, 0.3);
            z-index: 1;
        }

        /* Colores específicos para usuarios y estándares */
        .fc-event.available.user-1 {
            background-color: #FFDDC1 !important;
            border-color: #ffb3a7;
        }

        .fc-event.available.user-2 {
            background-color: #FFABAB !important;
            border-color: #ff9a9e;
        }

        .fc-event.available.user-3 {
            background-color: #FFC3A0 !important;
            border-color: #ff9f7e;
        }

        .fc-event.selected.user-1 {
            background-color: #FF9AA2 !important;
            border-color: #ff6b6b;
        }

        .fc-event.selected.user-2 {
            background-color: #FFB7B2 !important;
            border-color: #ff6b6b;
        }

        .fc-event.selected.user-3 {
            background-color: #FF677D !important;
            border-color: #e55b6e;
        }

        .fc-event.available.standard-1 {
            background-color: #D4A5A5 !important;
            border-color: #b88d8d;
        }

        .fc-event.available.standard-2 {
            background-color: #F6C6C6 !important;
            border-color: #f5a5a5;
        }

        .fc-event.available.standard-3 {
            background-color: #F7B7A3 !important;
            border-color: #f5a74d;
        }

        .fc-event.selected.standard-1 {
            background-color: #F8C8C8 !important;
            border-color: #f7a7a7;
        }

        .fc-event.selected.standard-2 {
            background-color: #F8B6B6 !important;
            border-color: #f78c8c;
        }

        .fc-event.selected.standard-3 {
            background-color: #F8A4A4 !important;
            border-color: #f76d6d;
        }

        /* Estilos para los números de los días del calendario */
        .fc-daygrid-day-number {
            font-size: 16px;
            color: #333;
            font-weight: 600;
        }

        /* Estilos para la parte superior de los días en el calendario */
        .fc-daygrid-day-top {
            background-color: #f7f7f7;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            padding: 5px;
        }

        /* Resaltado del día actual */
        .fc-daygrid-day-top.fc-day-today {
            background-color: #e0e0e0;
            border: 2px solid #007bff;
            border-radius: 8px;
            color: #007bff;
        }

        /* Estilo para días de otros meses */
        .fc-daygrid-day-top.fc-day-other-month {
            color: #9e9e9e;
        }

        /* Estilos para los eventos al pasar el ratón por encima */
        .fc-event:hover {
            opacity: 0.9;
            cursor: pointer;
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Estilo para el contenedor del calendario */
        .fc-daygrid-day {
            position: relative;
        }

        .fc-daygrid-day-events {
            position: absolute;
            width: 100%;
            top: 0;
            left: 0;
            padding: 5px;
            box-sizing: border-box;
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
                buttonText: {
                    prev: 'Mes Anterior',
                    next: 'Mes Siguiente',
                    today: 'Ir al día de Hoy',
                    month: 'Mes',
                    week: 'Semana',
                    day: 'Día',
                    list: 'Lista'
                },
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                },
                views: {
                    timeGridWeek: {
                        titleFormat: {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        }
                    },
                    timeGridDay: {
                        titleFormat: {
                            year: 'numeric',
                            month: 'short',
                            day: 'numeric'
                        }
                    }
                },
                events: [
                    @foreach ($fechasDisponibles as $fecha)
                        {
                            title: `Fecha asignada por {{ $evaluador->name }} {{ $evaluador->secondName }} {{ $evaluador->paternalSurname }} {{ $evaluador->maternalSurname }}`,
                            start: '{{ $fecha->fecha->format('Y-m-d') }}',
                            classNames: [
                                'available',
                                getUserColorClass('{{ $fecha->user_id }}'),
                                getStandardColorClass('{{ $fecha->estandar_id }}')
                            ],
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
                            title: `Fecha Elegida por {{ $fechaElegida->user->name }} {{ $fechaElegida->user->secondName }} {{ $fechaElegida->user->paternalSurname }} {{ $fechaElegida->user->maternalSurname }}`,
                            start: '{{ $fechaElegida->fechaCompetencia->fecha->format('Y-m-d') }}',
                            classNames: [
                                'selected',
                                getUserColorClass('{{ $fechaElegida->user_id }}'),
                                getStandardColorClass('{{ $fechaElegida->estandar_id }}')
                            ],
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
                        var modal = new bootstrap.Modal(document.getElementById('availableDateModal'));
                        modal.show();
                    } else if (info.event.extendedProps.tipo === 'elegida') {
                        document.getElementById('selectedEventStandard').innerText = info.event
                            .extendedProps.estandar;
                        document.getElementById('selectedEventUser').innerText = info.event
                            .extendedProps.usuario;
                        document.getElementById('selectedEventDate').innerText = info.event
                            .extendedProps.fecha;
                        document.getElementById('selectedEventHours').innerText = info.event
                            .extendedProps.horarios;
                        var modal = new bootstrap.Modal(document.getElementById('selectedDateModal'));
                        modal.show();
                    }
                }
            });

            calendar.render();

            function getUserColorClass(userId) {
                const userColorMap = {
                    '1': 'user-1',
                    '2': 'user-2',
                    '3': 'user-3',
                    // Agrega más IDs y colores aquí
                };
                return userColorMap[userId] || 'user-default';
            }

            function getStandardColorClass(standardId) {
                const standardColorMap = {
                    '1': 'standard-1',
                    '2': 'standard-2',
                    '3': 'standard-3',
                    // Agrega más IDs y colores aquí
                };
                return standardColorMap[standardId] || 'standard-default';
            }

            document.getElementById('goToDateButton').addEventListener('click', function() {
                var date = document.getElementById('datePicker').value;
                if (date) {
                    calendar.gotoDate(date);

                    calendar.addEvent({
                        title: 'Fecha Seleccionada',
                        start: date,
                        allDay: true,
                        classNames: ['highlighted'],
                        color: 'transparent',
                    });

                    setTimeout(function() {
                        calendar.getEvents().forEach(function(event) {
                            if (event.title === 'Fecha Seleccionada') {
                                event.remove();
                            }
                        });
                    }, 5000);
                }
            });
        });
    </script>

@stop
