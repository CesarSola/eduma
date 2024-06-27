@extends('adminlte::page')

@section('title', 'SICE')

@section('content_header')
    <div class="card">
        <div class="card-body-1 text-center-1">
            <p>SUBIR COMPROBANTE DE PAGO</p>
        </div>
    </div>
@stop

@section('content')
    <div class="card mb-3" style="max-width: 600px; margin: auto;">
        <div class="card-body-1 d-flex justify-content-center align-items-center">
            <div class="d-flex flex-column text-center">
                <h6>{{ $curso->numero }} {{ $curso->name }} {{ $curso->tipo }}</h6>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column mb-3">
        <div class="card mb-3" style="width: 48%; align-self: flex-start;">
            <div class="card-body">
                <h6>REQUISITOS PARA LA EVALUACIÓN Y CERTIFICACIÓN</h6>
                <h6>INFORMACIÓN DEL CURSO</h6>
                <h6>{{ $curso->Dnecesarios }}</h6>
            </div>
        </div>

        <div class="d-flex justify-content-between" style="width: 100%;">
            <div class="card mb-3" style="width: 48%; margin: auto;">
                <div class="card-body text-center">
                    @if ($comprobanteExistente)
                        <p>Comprobante de pago subido correctamente.</p>
                        <a href="{{ Storage::url($comprobanteExistente->comprobante_pago) }}" class="btn btn-primary">Ver Comprobante</a>
                    @else
                        <!-- Formulario para subir el comprobante de pago -->
                        <form action="{{ route('curso.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="curso_id" value="{{ $curso->id }}">
                            <div class="form-group">
                                <label for="comprobante_pago">Comprobante de Pago (PDF):</label>
                                <input type="file" name="comprobante_pago" class="form-control" accept=".pdf" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Subir</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-3">
            <a href="" class="btn btn-success">Evidencias</a>
            <a href="{{ route('curso.index') }}" class="btn btn-secondary">Volver</a>
        </div>
    </div>
@stop

@section('css')
    <style>
        .card-title {
            background-color: #5cb85c;
            padding: 10px;
            color: white;
            border-radius: 5px;
        }

        .card-header h3 {
            margin: 0;
        }

        .card-body {
            background-color: #dff0d8;
            padding: 20px;
            border: 1px solid #5cb85c;
            border-radius: 5px;
        }

        .card-body-1 {
            background-color: #5cb85c;
            padding: 10px;
            border: 1px solid #5cb85c;
            border-radius: 5px;
            color: #fff;
            text-align: center;
        }

        .text-center {
            color: #000;
        }

        .text-center-1 {
            color: #fff;
            text-align: center;
        }

        .text-left {
            color: #000;
        }

        .d-flex.align-items-center h6 {
            margin-bottom: 0;
        }

        .btn-success {
            background-color: #5cb85c;
            border-color: #5cb85c;
            color: white;
        }

        .btn-success:hover {
            background-color: #4cae4c;
            border-color: #4cae4c;
        }

        .btn-primary {
            background-color: #0275d8;
            border-color: #0275d8;
            color: white;
        }

        .btn-primary:hover {
            background-color: #025aa5;
            border-color: #025aa5;
        }
    </style>
@stop

@section('js')
    <script>
        console.log("Hi, I'm using the Laravel-AdminLTE package!");
    </script>
@stop
