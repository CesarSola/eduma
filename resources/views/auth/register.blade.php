<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Estilos adicionales */
        body {
            background-color: #f2f2f2;
        }

        .card {
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .progress-bar {
            background-color: #007bff;
        }

        .progress-container {
            text-align: center;
        }

        .progress-container img {
            width: 100px;
            margin-bottom: 20px;
        }

        .text-center {
            text-align: center;
        }

        .text-lg {
            font-size: 1.125rem;
            /* 18px */
        }

        .font-bold {
            font-weight: bold;
        }

        .text-neutral-600 {
            color: #000000;
            /* Color neutral */
        }

        .lg-text-4xl {
            font-size: 2.25rem;
            /* 36px */
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <!-- Formulario de Registro -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card">

                    <!-- Imagen centrada y progreso del registro -->
                    <div class="row justify-content-center">
                        <div class="col-md-6 progress-container">
                            <img src="{{ asset('assets/img/logo.jpeg') }}" alt="Imagen de registro"
                                style="width: 300px">
                        </div>
                    </div>

                    <form id="register-form" action="{{ route('register') }}" method="post">
                        @csrf

                        <!-- Primera sección -->
                        <div id="step-1">
                            <div class="d-flex justify-content-center align-items-center">
                                <h1 class="text-center text-lg font-bold text-neutral-600 leading-6 lg-text-4xl">
                                    Registrate con nosotros</h1>
                            </div>
                            <br>
                            <div class="row">
                                <!-- Name -->
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text" name="name"
                                            class="form-control @error('name') is-invalid @enderror"
                                            placeholder="{{ __('Primer nombre') }}" value="{{ old('name') }}" required
                                            autofocus>
                                        @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Last Name -->
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text" name="secondName"
                                            class="form-control @error('secondName') is-invalid @enderror"
                                            placeholder="{{ __('Segundo nombre') }}" value="{{ old('secondName') }}"
                                            required>
                                        @error('secondName')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text" name="paternalSurname"
                                            class="form-control @error('paternalSurname') is-invalid @enderror"
                                            placeholder="{{ __('Apellido paterno') }}"
                                            value="{{ old('paternalSurname') }}" required>
                                        @error('paternalSurname')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="text" name="maternalSurname"
                                            class="form-control @error('maternalSurname') is-invalid @enderror"
                                            placeholder="{{ __('Apellido materno') }}"
                                            value="{{ old('maternalSurname') }}" required>
                                        @error('maternalSurname')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Email Address -->
                            <div class="input-group mb-3">
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="{{ __('Correo') }}" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row">
                                <!-- Password -->
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="{{ __('Contraseña') }}" required>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="col-md-6">
                                    <div class="input-group mb-3">
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="{{ __('Verificar contraseña') }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center align-items-center">
                                <a href="{{ url('/google-auth/redirect') }}">
                                    <img src="{{ asset('assets/img/image.png') }}" alt="Google Auth"
                                        style="width: 30px">
                                </a>
                            </div>
                            <br>
                            <div class="mb-4">
                                <div class="d-flex justify-content-center align-items-center">
                                    <button type="button" id="next-btn" class="btn btn-primary"
                                        style="width: 300px;">{{ __('Siguiente Paso') }}</button>
                                </div>
                            </div>
                        </div>

                        <!-- Segunda sección -->
                        <div id="step-2" style="display:none;">
                            <!-- Código Postal -->
                            <div class="input-group mb-3">
                                <input type="text" id="codigo_postal" name="codigo_postal"
                                    class="form-control @error('codigo_postal') is-invalid @enderror"
                                    placeholder="{{ __('Código Postal') }}" value="{{ old('codigo_postal') }}"
                                    required>
                                <div class="input-group-append">
                                    <button type="button" id="buscar-btn" class="btn btn-primary">Buscar</button>
                                </div>
                                @error('codigo_postal')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Selects para colonia, municipio, estado y ciudad -->
                            <div class="input-group mb-3">
                                <select id="d_asenta" name="d_asenta"
                                    class="form-control @error('d_asenta') is-invalid @enderror">
                                    <option value="">Selecciona una colonia</option>
                                </select>
                                @error('d_asenta')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="input-group mb-3">
                                <select id="D_mnpio" name="D_mnpio"
                                    class="form-control @error('D_mnpio') is-invalid @enderror">
                                    <option value="">Selecciona un municipio</option>
                                </select>
                                @error('D_mnpio')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="input-group mb-3">
                                <select id="d_estado" name="d_estado"
                                    class="form-control @error('d_estado') is-invalid @enderror">
                                    <option value="">Selecciona un estado</option>
                                </select>
                                @error('d_estado')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="input-group mb-3">
                                <select id="d_ciudad" name="d_ciudad"
                                    class="form-control @error('d_ciudad') is-invalid @enderror">
                                    <option value="">Selecciona una ciudad</option>
                                </select>
                                @error('d_ciudad')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- Edad -->
                            <div class="input-group mb-3">
                                <input type="number" name="age"
                                    class="form-control @error('age') is-invalid @enderror"
                                    placeholder="{{ __('Edad') }}" value="{{ old('age') }}" required>
                                @error('age')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            <!-- Teléfono -->
                            <div class="input-group mb-3">
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="{{ __('Número de teléfono') }}" value="{{ old('phone') }}"
                                    required>
                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="input-group mb-3">
                                <select id="genero" name="genero"
                                    class="form-control @error('genero') is-invalid @enderror">
                                    <option value="">Seleccione su género</option>
                                    <option value="Hombre" {{ old('genero') == 'Hombre' ? 'selected' : '' }}>Hombre
                                    </option>
                                    <option value="Mujer" {{ old('genero') == 'Mujer' ? 'selected' : '' }}>Mujer
                                    </option>
                                    <option value="Otro" {{ old('genero') == 'Otro' ? 'selected' : '' }}>Prefiero
                                        no contestar</option>
                                </select>
                                @error('genero')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                                        <label for="agreeTerms">
                                            {{ __('I agree to the') }} <a href="#">{{ __('terms') }}</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <button type="submit"
                                        class="btn btn-primary btn-block">{{ __('Register') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#next-btn').click(function() {
                // Validación de los campos del primer paso
                var name = $('input[name="name"]').val();
                var email = $('input[name="email"]').val();
                var password = $('input[name="password"]').val();
                var password_confirmation = $('input[name="password_confirmation"]').val();

                if (name && email && password && password === password_confirmation) {
                    $('#step-1').hide();
                    $('#step-2').show();
                } else {
                    alert('Por favor, completa todos los campos correctamente.');
                }
            });

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

                            // Limpiar y rellenar los selectores
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

                            // Rellenar los selectores con la primera opción
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

                            // Iterar sobre el resto de opciones y llenar los selectores
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

                            // Ocultar campos vacíos si no se encontraron resultados
                            if (!primerLugar.d_asenta) {
                                coloniaSelect.hide();
                            }
                            if (!primerLugar.D_mnpio) {
                                municipioSelect.hide();
                            }
                            if (!primerLugar.d_estado) {
                                estadoSelect.hide();
                            }
                            if (!primerLugar.d_ciudad) {
                                ciudadSelect.hide();
                            }

                        } else {
                            console.log(response.error);
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        console.log('Error al obtener los detalles: ' + textStatus);
                    }
                });
            });
        });
    </script>


</body>

</html>
