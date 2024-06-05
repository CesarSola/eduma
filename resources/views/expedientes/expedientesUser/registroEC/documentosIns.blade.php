@extends('adminlte::page')

@section('title', 'Subir Documentos de Inscripción')

@section('content_header')
    <h1>Subir Documentos de Inscripción</h1>
@stop

@section('content')
    <form action="{{ route('competenciaEC.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <h6 style="text-align: center" class="card-title">Documentos</h6>
            <div class="card-body">
                <div class="form-group">
                    <label for="ficha_inscripcion">Ficha de Inscripción (PDF):</label>
                    <input type="file" class="form-control" name="ficha_inscripcion" accept=".pdf" required
                        onchange="previewPDF(event, 'ficha_inscripcion-preview')">
                    <embed id="ficha_inscripcion-preview" src="#" type="application/pdf" width="100%"
                        height="200px" style="display:none; margin-top: 10px;" />
                </div>

                <button type="submit" class="btn btn-primary">Subir documentos</button>
            </div>
        </div>
    </form>
@stop

@section('css')
    <style>
        .card-title {
            background-color: #5cb85c;
            padding: 10px;
            color: white;
            border-radius: 5px;
        }

        .card-body {
            background-color: #dff0d8;
            padding: 20px;
            border: 1px solid #5cb85c;
            border-radius: 5px;
        }

        .pdf-preview {
            width: 100%;
            height: 200px;
        }
    </style>
@stop

@section('js')
    <script>
        function previewPDF(event, previewId) {
            var output = document.getElementById(previewId);
            output.src = URL.createObjectURL(event.target.files[0]);
            output.classList.add('pdf-preview');
            output.style.display = 'block';
        }
    </script>
@stop
