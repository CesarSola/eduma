@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
@stop

@section('content')
    <div class="container">
        <div class="card mb-4">
            <div class="card-body">
                <form method="post" action="{{ route('profile.update') }}" class="mt-6" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <!-- Contenedor de la imagen y carga -->
                    <div class="mb-4">
                        <label class="form-label" for="foto">Foto de perfil</label>
                        <div class="preview-container mb-4">
                            <img src="{{ $user->foto ? asset($user->foto) : asset('default-avatar.png') }}"
                                id="previewImage" width="200" height="200" class="rounded-circle shadow-lg mb-4">
                            <label for="foto" class="btn btn-primary">
                                Seleccionar imagen
                                <input id="foto" name="foto" type="file" class="text-sm cursor-pointer d-none"
                                    onchange="previewFile()" accept="image/*">
                            </label>
                            @if ($errors->has('foto'))
                                <div class="text-danger mt-2">{{ $errors->first('foto') }}</div>
                            @endif
                        </div>
                    </div>
                    <!-- Aquí puedes agregar más campos del formulario si es necesario -->

                    <div class="row">
                        <!-- Primera Columna -->
                        <div class="col-sm-6">
                            <!-- Nombre -->
                            <div class="mb-4">
                                <label for="name" class="form-label">{{ __('Nombre') }}</label>
                                <input id="name" name="name" type="text" class="form-control"
                                    value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                                @if ($errors->get('name'))
                                    <div class="text-danger mt-2">{{ $errors->first('name') }}</div>
                                @endif
                            </div>
                            <!-- Apellido paterno -->
                            <div class="mb-4">
                                <label for="paternalSurname" class="form-label">{{ __('Apellido Paterno') }}</label>
                                <input id="paternalSurname" name="paternalSurname" type="text" class="form-control"
                                    value="{{ old('paternalSurname', $user->paternalSurname) }}" required autofocus
                                    autocomplete="paternalSurname" />
                                @if ($errors->get('paternalSurname'))
                                    <div class="text-danger mt-2">{{ $errors->first('paternalSurname') }}</div>
                                @endif
                            </div>
                            <!-- Edad -->
                            <div class="mb-4">
                                <label for="age" class="form-label">{{ __('Edad') }}</label>
                                <input id="age" name="age" type="number" class="form-control"
                                    value="{{ old('age', $user->age) }}" required autofocus autocomplete="age" />
                                @if ($errors->get('age'))
                                    <div class="text-danger mt-2">{{ $errors->first('age') }}</div>
                                @endif
                            </div>
                            <!-- Calle o Avenida -->
                            <div class="mb-4">
                                <label for="calle_avenida" class="form-label">{{ __('Calle o Avenida') }}</label>
                                <input id="calle_avenida" name="calle_avenida" type="text" class="form-control"
                                    value="{{ old('calle_avenida', $user->calle_avenida) }}" required autofocus
                                    autocomplete="calle_avenida" />
                                @if ($errors->get('calle_avenida'))
                                    <div class="text-danger mt-2">{{ $errors->first('calle_avenida') }}</div>
                                @endif
                            </div>
                            <!-- Codigo postal -->
                            <div class="mb-4">
                                <label for="codigo_postal" class="form-label">{{ __('Código Postal') }}</label>
                                <div class="input-group">
                                    <input type="text" id="codigo_postal" name="codigo_postal"
                                        value="{{ old('codigo_postal', $user->d_codigo) }}" required class="form-control">
                                    <button type="button" id="buscar-btn" class="btn btn-outline-secondary"
                                        style="color: blue">Buscar</button>
                                </div>
                            </div>
                            <!-- Estado -->
                            <div class="mb-4">
                                <label for="d_estado" class="form-label">{{ __('Estado') }}</label>
                                <select id="d_estado" name="d_estado" class="form-select">
                                    <option value="">Selecciona un estado</option>
                                    @php
                                        $estados = new \Illuminate\Support\Collection();
                                    @endphp
                                    @foreach ($codigosPostales as $codigoPostal)
                                        @unless ($estados->contains($codigoPostal->d_estado))
                                            <option value="{{ $codigoPostal->d_estado }}"
                                                {{ $user->d_estado == $codigoPostal->d_estado ? 'selected' : '' }}>
                                                {{ $codigoPostal->d_estado }}</option>
                                            @php
                                                $estados->push($codigoPostal->d_estado);
                                            @endphp
                                        @endunless
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Segunda Columna -->
                        <div class="col-sm-6">
                            <!-- Segundo Nombre -->
                            <div class="mb-4">
                                <label for="secondName" class="form-label">{{ __('Segundo Nombre') }}</label>
                                <input id="secondName" name="secondName" type="text" class="form-control"
                                    value="{{ old('secondName', $user->secondName) }}" required autofocus
                                    autocomplete="secondName" />
                                @error('secondName')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Apellido Materno -->
                            <div class="mb-4">
                                <label for="maternalSurname" class="form-label">{{ __('Apellido Materno') }}</label>
                                <input id="maternalSurname" name="maternalSurname" type="text" class="form-control"
                                    value="{{ old('maternalSurname', $user->maternalSurname) }}" required autofocus
                                    autocomplete="maternalSurname" />
                                @error('maternalSurname')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Género -->
                            <div class="mb-4">
                                <label for="genero" class="form-label">{{ __('Género') }}</label>
                                <select id="genero" name="genero" class="form-select">
                                    <option value="Hombre" {{ $user->genero === 'Hombre' ? 'selected' : '' }}>Hombre
                                    </option>
                                    <option value="Mujer" {{ $user->genero === 'Mujer' ? 'selected' : '' }}>Mujer
                                    </option>
                                    <option value="Prefiero no contestar"
                                        {{ $user->genero === 'Prefiero no contestar' ? 'selected' : '' }}>
                                        Prefiero no contestar
                                    </option>
                                </select>
                                @error('genero')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Correo Electrónico -->
                            <div class="mb-4">
                                <label for="email" class="form-label">{{ __('Correo') }}</label>
                                <input id="email" name="email" type="text" class="form-control"
                                    value="{{ old('email', $user->email) }}" required autofocus autocomplete="email" />
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Número Exterior -->
                            <div class="mb-4">
                                <label for="numext" class="form-label">{{ __('Número Exterior') }}</label>
                                <input id="numext" name="numext" type="text" class="form-control"
                                    value="{{ old('numext', $user->numext) }}" required autofocus
                                    autocomplete="numext" />
                                @error('numext')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Ciudad -->
                            <div class="mb-4">
                                <label for="d_ciudad" class="form-label">{{ __('Ciudad') }}</label>
                                <select id="d_ciudad" name="d_ciudad" class="form-select">
                                    <option value="">Selecciona una ciudad</option>
                                    @php
                                        $ciudades = new \Illuminate\Support\Collection();
                                    @endphp
                                    @foreach ($codigosPostales as $codigoPostal)
                                        @unless ($ciudades->contains($codigoPostal->d_ciudad))
                                            <option value="{{ $codigoPostal->d_ciudad }}"
                                                {{ $user->d_ciudad == $codigoPostal->d_ciudad ? 'selected' : '' }}>
                                                {{ $codigoPostal->d_ciudad }}</option>
                                            @php
                                                $ciudades->push($codigoPostal->d_ciudad);
                                            @endphp
                                        @endunless
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Tercera Columna -->
                        <div class="col-sm-6">
                            <!-- Colonia -->
                            <div class="mb-4">
                                <label for="d_asenta" class="form-label">{{ __('Colonia') }}</label>
                                <select id="d_asenta" name="d_asenta" class="form-select">
                                    <option value="">Selecciona una colonia</option>
                                    @php
                                        $asentas = new \Illuminate\Support\Collection();
                                    @endphp
                                    @foreach ($codigosPostales as $codigoPostal)
                                        @unless ($asentas->contains($codigoPostal->d_asenta))
                                            <option value="{{ $codigoPostal->d_asenta }}"
                                                {{ $user->d_asenta == $codigoPostal->d_asenta ? 'selected' : '' }}>
                                                {{ $codigoPostal->d_asenta }}</option>
                                            @php
                                                $asentas->push($codigoPostal->d_asenta);
                                            @endphp
                                        @endunless
                                    @endforeach
                                </select>
                            </div>

                            <!-- Fecha de Nacimiento -->
                            <div class="mb-4">
                                <label for="nacimiento" class="form-label">{{ __('Fecha de Nacimiento') }}</label>
                                <input id="nacimiento" name="nacimiento" type="date" class="form-control"
                                    value="{{ old('nacimiento', $user->nacimiento) }}" required autofocus
                                    autocomplete="nacimiento" />
                                @error('nacimiento')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- CURP -->
                            <div class="mb-4">
                                <label for="curp" class="form-label">{{ __('CURP') }}</label>
                                <input id="curp" name="curp" type="text" class="form-control"
                                    value="{{ old('curp', $user->curp) }}" required autofocus autocomplete="curp" />
                                @error('curp')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Cuarta Columna -->
                        <div class="col-sm-6">
                            <!-- Municipio -->
                            <div class="mb-4">
                                <label for="D_mnpio" class="form-label">{{ __('Municipio') }}</label>
                                <select id="D_mnpio" name="D_mnpio" class="form-select">
                                    <option value="">Selecciona un municipio</option>
                                    @php
                                        $municipios = new \Illuminate\Support\Collection();
                                    @endphp
                                    @foreach ($codigosPostales as $codigoPostal)
                                        @unless ($municipios->contains($codigoPostal->D_mnpio))
                                            <option value="{{ $codigoPostal->D_mnpio }}"
                                                {{ $user->D_mnpio == $codigoPostal->D_mnpio ? 'selected' : '' }}>
                                                {{ $codigoPostal->D_mnpio }}</option>
                                            @php
                                                $municipios->push($codigoPostal->D_mnpio);
                                            @endphp
                                        @endunless
                                    @endforeach
                                </select>
                            </div>

                            <!-- Teléfono -->
                            <div class="mb-4">
                                <label for="phone" class="form-label">{{ __('Teléfono') }}</label>
                                <input id="phone" name="phone" type="text" class="form-control"
                                    value="{{ old('phone', $user->phone) }}" required autofocus autocomplete="phone" />
                                @error('phone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nacionalidad -->
                            <div class="mb-4">
                                <label for="nacionalidad" class="form-label">{{ __('Nacionalidad') }}</label>
                                <input id="nacionalidad" name="nacionalidad" type="text" class="form-control"
                                    value="{{ old('nacionalidad', $user->nacionalidad) }}" required autofocus
                                    autocomplete="nacionalidad" />
                                @error('nacionalidad')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <x-primary-button>{{ __('Guardar') }}</x-primary-button>

                        @if (session('status') === 'profile-updated')
                            <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-gray-600">{{ __('Guardado') }}</p>
                        @endif

                        <button type="button" class="btn btn-success" data-toggle="modal"
                            data-target="#exampleModalCenter">
                            Cambiar contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <header>
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Actualizar Contraseña') }}
                        </h2>

                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Asegúrate de que tu cuenta esté utilizando una contraseña larga y aleatoria para mantenerla segura.') }}
                        </p>
                    </header>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('profile.partials.update-password-form')
                </div>

            </div>
        </div>
    </div>
    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
@stop
@section('css')
    <style>
        .container {
            background-color: white;
            width: 100%;
            padding: 50px;
            border-radius: 10px;
        }

        .container-1 {
            background-color: white;
            width: 60%;
            /* Ancho reducido al 60% para dejar 20% de margen en cada lado */
            padding: 10px;
            border-radius: 10px;
            margin: 0 auto;
            /* Centrado horizontal */
            display: flex;
            justify-content: center;
            /* Centra el contenido horizontalmente */
            align-items: center;
            /* Centra el contenido verticalmente */
        }

        .container1.1 {
            display: flex;
            flex-direction: column;
            /* Organizar en columna */
            align-items: center;
            /* Centrar horizontalmente los elementos */
            width: 100%;
        }

        .preview-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        button {
            margin-top: 20px;
        }



        .flex-container {
            display: flex;
            padding: 20px;
            margin-left: 55px;
        }

        .Div-1 {
            margin-left: 10px;
        }

        .Div-2 {
            margin-left: 55px;
        }

        .Div-3 {
            margin-left: 55px;
        }

        .Div-4 {
            margin-left: 55px;
        }

        .Div-5 {
            margin-left: 55px;
        }
    </style>
@stop

@section('js')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $('#buscar-btn').click(function() {
            var codigoPostal = $('#codigo_postal').val();

            $.ajax({
                type: 'POST',
                url: "{{ route('obtener-detalles-codigo-postal') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    codigo_postal: codigoPostal
                },
                success: function(response) {
                    if (response.codigosPostales) {
                        var coloniaSelect = $('#d_asenta');
                        var municipioSelect = $('#D_mnpio');
                        var estadoSelect = $('#d_estado');
                        var ciudadSelect = $('#d_ciudad');

                        coloniaSelect.empty().append(
                            '<option value="">Selecciona una colonia</option>');
                        municipioSelect.empty().append(
                            '<option value="">Selecciona un municipio</option>');
                        estadoSelect.empty().append(
                            '<option value="">Selecciona un estado</option>');
                        ciudadSelect.empty().append(
                            '<option value="">Selecciona una ciudad</option>');

                        var municipiosUnicos = new Set();
                        var estadosUnicos = new Set();
                        var ciudadesUnicas = new Set();

                        var primerLugar = response.codigosPostales[0];

                        coloniaSelect.append('<option value="' + primerLugar.d_asenta +
                            '" selected>' + primerLugar.d_asenta + '</option>');
                        municipioSelect.append('<option value="' + primerLugar.D_mnpio +
                            '" selected>' + primerLugar.D_mnpio + '</option>');
                        estadoSelect.append('<option value="' + primerLugar.d_estado +
                            '" selected>' + primerLugar.d_estado + '</option>');
                        ciudadSelect.append('<option value="' + primerLugar.d_ciudad +
                            '" selected>' + primerLugar.d_ciudad + '</option>');

                        municipiosUnicos.add(primerLugar.D_mnpio);
                        estadosUnicos.add(primerLugar.d_estado);
                        ciudadesUnicas.add(primerLugar.d_ciudad);

                        $.each(response.codigosPostales, function(index, lugar) {
                            if (index !== 0) {
                                coloniaSelect.append('<option value="' + lugar
                                    .d_asenta + '">' + lugar.d_asenta +
                                    '</option>');

                                if (!municipiosUnicos.has(lugar.D_mnpio)) {
                                    municipioSelect.append('<option value="' + lugar
                                        .D_mnpio + '">' + lugar.D_mnpio +
                                        '</option>');
                                    municipiosUnicos.add(lugar.D_mnpio);
                                }
                                if (!estadosUnicos.has(lugar.d_estado)) {
                                    estadoSelect.append('<option value="' + lugar
                                        .d_estado + '">' + lugar.d_estado +
                                        '</option>');
                                    estadosUnicos.add(lugar.d_estado);
                                }
                                if (!ciudadesUnicas.has(lugar.d_ciudad)) {
                                    ciudadSelect.append('<option value="' + lugar
                                        .d_ciudad + '">' + lugar.d_ciudad +
                                        '</option>');
                                    ciudadesUnicas.add(lugar.d_ciudad);
                                }
                            }
                        });
                    } else {
                        console.log(response.error);
                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log('Error al obtener los detalles: ' + textStatus);
                }
            });
        });
    </script>

    <script>
        function previewFile() {
            const preview = document.getElementById('previewImage');
            const file = document.getElementById('foto').files[0];
            const reader = new FileReader();

            reader.addEventListener("load", function() {
                // Convert file to base64 string
                preview.src = reader.result;
            }, false);

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
@stop
