@extends('adminlte::page')

@section('title', 'Re-subir Comprobante de Pago')

@section('content_header')
    <h1>Re-subir Comprobante de Pago</h1>
    <div>
        <a href="{{ route('miscompetencias.index') }}" class="btn btn-secondary">Regresar</a>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h5 class="card-title">Competencia: {{ $competencia->name }}</h5>
            <p class="card-text">Por favor, sube nuevamente el comprobante de pago.</p>

            <form action="{{ route('miscompetencias.guardarResubirComprobante', ['id' => $competencia->id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                <!-- Mostrar comentarios y tipo de validación del admin -->
                @if ($validacionComentario)
                    <div class="form-group">
                        <label for="tipo_validacion">Tipo de validación anterior:</label>
                        <input type="text" class="form-control" id="tipo_validacion" name="tipo_validacion"
                            value="{{ $validacionComentario->tipo_validacion }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="comentario_validacion">Comentario de validación anterior:</label>
                        <textarea class="form-control" id="comentario_validacion" name="comentario_validacion" rows="3" readonly>{{ $validacionComentario->comentario }}</textarea>
                    </div>
                @endif

                <div class="form-group">
                    <label for="nuevo_comprobante_pago">Nuevo comprobante de pago:</label>
                    <input type="file" class="form-control-file" id="nuevo_comprobante_pago"
                        name="nuevo_comprobante_pago" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar y Re-subir</button>
                <a href="{{ route('miscompetencias.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>

        </div>
    </div>
@stop
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Mostrar SweetAlert2 cuando se sube un comprobante exitosamente
        @if (session('success'))
            Swal.fire({
                title: 'Éxito',
                text: '{{ session('success') }}',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@stop
