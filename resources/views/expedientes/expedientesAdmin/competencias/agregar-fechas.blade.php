@extends('adminlte::page')

@section('title', 'Agregar Fechas')

@section('content_header')
    <h1>Agregar Fechas a {{ $competencia->name }}</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <!-- Formulario para agregar fechas -->
            <form action="{{ route('competencias.guardar-fechas', ['competencia' => $competencia->id]) }}" method="POST"
                id="formAgregarFechas">
                @csrf
                <div id="fechasContainer">
                    @foreach ($competencia->fechas as $fecha)
                        <div class="form-group">
                            <label for="fecha">Fecha:</label>
                            <input type="date" name="fechas[]" class="form-control" value="{{ $fecha->fecha }}" readonly>
                        </div>
                    @endforeach

                    @for ($i = count($competencia->fechas); $i < 3; $i++)
                        <div class="form-group">
                            <label for="fecha">Fecha:</label>
                            <input type="date" name="fechas[]" class="form-control" required>
                        </div>
                    @endfor
                </div>
                <button type="button" class="btn btn-success" id="btnAgregarFecha">Agregar Otra Fecha</button>
                <button type="submit" class="btn btn-primary">Agregar Fechas</button>
            </form>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Script para agregar dinámicamente más campos de fecha
        document.addEventListener('DOMContentLoaded', function() {
            const btnAgregarFecha = document.getElementById('btnAgregarFecha');
            const fechasContainer = document.getElementById('fechasContainer');

            btnAgregarFecha.addEventListener('click', function() {
                // Verificar cuántos campos de fecha hay actualmente
                const camposFecha = fechasContainer.querySelectorAll('.form-group').length;

                if (camposFecha < 3) {
                    const nuevaFechaInput = document.createElement('div');
                    nuevaFechaInput.classList.add('form-group');
                    nuevaFechaInput.innerHTML = `
                        <label for="fecha">Fecha:</label>
                        <input type="date" name="fechas[]" class="form-control" required>
                    `;
                    fechasContainer.appendChild(nuevaFechaInput);
                } else {
                    alert('Solo se permiten 3 fechas.');
                }
            });
        });
    </script>
@stop
