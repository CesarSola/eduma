@extends('adminlte::page')

@section('title', 'Agregar Fechas')

@section('content_header')
    <h1>Agregar Fechas a {{ $competencia->name }} para {{ $usuario->name }} {{ $usuario->secondName }}
        {{ $usuario->paternalSurname }} {{ $usuario->maternalSurname }}</h1>
    <a href="{{ route('competencia.index', ['user_id' => $selectedUserId]) }}" class="btn btn-secondary mt-3">Regresar</a>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <!-- Formulario para agregar fechas -->
            <form action="{{ route('competencias.guardar-fechas', ['competencia' => $competencia->id]) }}" method="POST"
                id="formGuardarFechas">
                @csrf
                <input type="hidden" name="user_id" value="{{ $selectedUserId }}">

                <div id="fechasContainer">
                    @foreach ($fechasUsuario as $index => $fecha)
                        <div class="form-group mb-4">
                            <label for="fecha">Fecha:</label>
                            <input type="date" name="fechas[]" class="form-control"
                                value="{{ $fecha->fecha->format('Y-m-d') }}" required>
                            <label for="hora" class="mt-2">Horarios:</label>
                            @foreach ($fecha->horarios as $horario)
                                <input type="time" name="horarios[{{ $index }}][]" class="form-control mb-2"
                                    value="{{ $horario->hora }}" required>
                            @endforeach
                            <div class="horariosContainer mt-2">
                                <!-- Aquí se agregarán nuevos campos de hora -->
                            </div>
                        </div>
                    @endforeach

                    @for ($i = count($fechasUsuario); $i < 3; $i++)
                        <div class="form-group mb-4">
                            <label for="fecha">Fecha:</label>
                            <input type="date" name="fechas[]" class="form-control" required>
                            <label for="hora" class="mt-2">Horarios:</label>
                            <div class="horariosContainer">
                                <input type="time" name="horarios[{{ $i }}][]" class="form-control mb-2"
                                    required>
                            </div>
                        </div>
                    @endfor
                </div>
                @unless ($tieneFechasYHorarios)
                    <button type="submit" class="btn btn-primary btn-block">Guardar Fechas y Horarios</button>
                @endunless
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('fechasContainer').addEventListener('click', function(event) {
                if (event.target && event.target.classList.contains('btnAgregarHorario')) {
                    const formGroup = event.target.closest('.form-group');
                    const horariosContainer = formGroup.querySelector('.horariosContainer');

                    // Contar los campos de horario existentes para esta fecha
                    const existingHorariosCount = formGroup.querySelectorAll('input[type="time"]').length;

                    // Crear un nuevo campo de horario
                    const nuevoCampoHorario = document.createElement('input');
                    nuevoCampoHorario.type = 'time';
                    nuevoCampoHorario.name =
                        `horarios[${existingHorariosCount}][]`; // Usar el conteo actual como índice
                    nuevoCampoHorario.classList.add('form-control', 'mb-2');
                    nuevoCampoHorario.required = true;

                    horariosContainer.appendChild(nuevoCampoHorario);
                }
            });
        });
    </script>
@stop
