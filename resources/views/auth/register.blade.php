

@extends('adminlte::auth.auth-page', ['auth_type' => 'register'])

@section('auth_header', __('Register a new membership'))

@section('auth_body')
    <form id="register-form" action="{{ route('register') }}" method="post">
        @csrf

        <!-- Primera sección -->
        <div id="step-1">
            <!-- Name -->
            <div class="input-group mb-3">
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Nombres') }}" value="{{ old('name') }}" required autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-user"></span>
                    </div>
                </div>
                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
                <!-- Last Name -->
    <div class="input-group mb-3">
        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="{{ __('Apellidos') }}" value="{{ old('last_name') }}" required>
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-user"></span>
            </div>
        </div>
        @error('last_name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

            <!-- Email Address -->
            <div class="input-group mb-3">
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Correo') }}" value="{{ old('email') }}" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Password -->
            <div class="input-group mb-3">
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Contraseña') }}" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="input-group mb-3">
                <input type="password" name="password_confirmation" class="form-control" placeholder="{{ __('Verificar contraseña') }}" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>

            <button type="button" id="next-btn" class="btn btn-primary btn-block">{{ __('Next') }}</button>
        </div>

        <!-- Segunda sección -->
        <div id="step-2" style="display:none;">
            <!-- Código Postal -->
            <div class="input-group mb-3">
                <input type="text" id="codigo_postal" name="codigo_postal" class="form-control @error('codigo_postal') is-invalid @enderror" placeholder="{{ __('Código Postal') }}" value="{{ old('codigo_postal') }}" required>
                <div class="input-group-append">
                    <button type="button" id="buscar-btn" class="btn btn-primary">Buscar</button>
                </div>
                @error('codigo_postal')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Colonia -->
            <div class="input-group mb-3">
                <select id="d_asenta" name="d_asenta" class="form-control @error('d_asenta') is-invalid @enderror">
                    <option value="">Selecciona una colonia</option>
                </select>
                @error('d_asenta')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Municipio -->
            <div class="input-group mb-3">
                <select id="D_mnpio" name="D_mnpio" class="form-control @error('D_mnpio') is-invalid @enderror">
                    <option value="">Selecciona un municipio</option>
                </select>
                @error('D_mnpio')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Estado -->
            <div class="input-group mb-3">
                <select id="d_estado" name="d_estado" class="form-control @error('d_estado') is-invalid @enderror">
                    <option value="">Selecciona un estado</option>
                </select>
                @error('d_estado')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Ciudad -->
            <div class="input-group mb-3">
                <select id="d_ciudad" name="d_ciudad" class="form-control @error('d_ciudad') is-invalid @enderror">
                    <option value="">Selecciona una ciudad</option>
                </select>
                @error('d_ciudad')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <!-- Género -->
            <div class="input-group mb-3">
                <select id="genero" name="genero" class="form-control @error('genero') is-invalid @enderror">
                    <option value="">{{ __('Seleccione su genero') }}</option>
                    <option value="male">{{ __('Hombre') }}</option>
                    <option value="female">{{ __('Mujer') }}</option>
                    <option value="other">{{ __('Prefiero no contestar') }}</option>
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
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('login') }}">{{ __('I already have a membership') }}</a>
    </p>
@endsection

@section('js')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#next-btn').click(function() {
            // Validación de los campos del primer paso (puedes agregar más validaciones si es necesario)
            var name = $('input[name="name"]').val();
            var email = $('input[name="email"]').val();
            var password = $('input[name="password"]').val();
            var password_confirmation = $('input[name="password_confirmation"]').val();

            if(name && email && password && password === password_confirmation) {
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

                        coloniaSelect.empty().append('<option value="">Selecciona una colonia</option>');
                        municipioSelect.empty().append('<option value="">Selecciona un municipio</option>');
                        estadoSelect.empty().append('<option value="">Selecciona un estado</option>');
                        ciudadSelect.empty().append('<option value="">Selecciona una ciudad</option>');

                        var municipiosUnicos = new Set();
                        var estadosUnicos = new Set();
                        var ciudadesUnicas = new Set();

                        var primerLugar = response.codigosPostales[0];

                        coloniaSelect.append('<option value="' + primerLugar.d_asenta + '" selected>' + primerLugar.d_asenta + '</option>');
                        municipioSelect.append('<option value="' + primerLugar.D_mnpio + '" selected>' + primerLugar.D_mnpio + '</option>');
                        estadoSelect.append('<option value="' + primerLugar.d_estado + '" selected>' + primerLugar.d_estado + '</option>');
                        ciudadSelect.append('<option value="' + primerLugar.d_ciudad + '" selected>' + primerLugar.d_ciudad + '</option>');

                        municipiosUnicos.add(primerLugar.D_mnpio);
                        estadosUnicos.add(primerLugar.d_estado);
                        ciudadesUnicas.add(primerLugar.d_ciudad);

                        $.each(response.codigosPostales, function(index, lugar) {
                            if (index !== 0) {
                                coloniaSelect.append('<option value="' + lugar.d_asenta + '">' + lugar.d_asenta + '</option>');

                                if (!municipiosUnicos.has(lugar.D_mnpio)) {
                                    municipioSelect.append('<option value="' + lugar.D_mnpio + '">' + lugar.D_mnpio + '</option>');
                                    municipiosUnicos.add(lugar.D_mnpio);
                                }
                                if (!estadosUnicos.has(lugar.d_estado)) {
                                    estadoSelect.append('<option value="' + lugar.d_estado + '">' + lugar.d_estado + '</option>');
                                    estadosUnicos.add(lugar.d_estado);
                                }
                                if (!ciudadesUnicas.has(lugar.d_ciudad)) {
                                    ciudadSelect.append('<option value="' + lugar.d_ciudad + '">' + lugar.d_ciudad + '</option>');
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
    });
    
</script>
@endsection
