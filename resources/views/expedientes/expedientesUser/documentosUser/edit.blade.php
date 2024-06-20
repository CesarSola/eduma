@extends('adminlte::page')

@section('title', 'Resubir Documento')

@section('content_header')
    <h1>Resubir Documento</h1>
    <div>
        <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Regresar</a>
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

            <form action="{{ route('documentosUser.update', $tipo_documento) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="{{ $tipo_documento }}">{{ ucfirst(str_replace('_', ' ', $tipo_documento)) }}</label>
                    <input type="file" name="{{ $tipo_documento }}" id="{{ $tipo_documento }}" class="form-control"
                        required>
                </div>

                <button type="submit" class="btn btn-primary">Subir</button>
            </form>
        </div>
    </div>
@stop
