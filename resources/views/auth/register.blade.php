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
      box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
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
            <img src="{{ asset('assets/img/logo.jpeg') }}" alt="Imagen de registro" style="width: 300px">
          </div>
        </div>

        <form id="register-form" action="{{ route('register') }}" method="post">
          @csrf

          <!-- Sección Personal -->
          <div id="personal-section">
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="name">{{ __('Primer nombre') }}</label>
                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="{{ __('Primer nombre') }}" value="{{ old('name') }}" required autofocus>
                @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="form-group col-md-6">
                <label for="secondName">{{ __('Segundo nombre') }}</label>
                <input type="text" id="secondName" name="secondName" class="form-control @error('secondName') is-invalid @enderror" placeholder="{{ __('Segundo nombre') }}" value="{{ old('secondName') }}" required>
                @error('secondName')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="paternalSurname">{{ __('Apellido paterno') }}</label>
                <input type="text" id="paternalSurname" name="paternalSurname" class="form-control @error('paternalSurname') is-invalid @enderror" placeholder="{{ __('Apellido paterno') }}" value="{{ old('paternalSurname') }}" required>
                @error('paternalSurname')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="form-group col-md-6">
                <label for="maternalSurname">{{ __('Apellido materno') }}</label>
                <input type="text" id="maternalSurname" name="maternalSurname" class="form-control @error('maternalSurname') is-invalid @enderror" placeholder="{{ __('Apellido materno') }}" value="{{ old('maternalSurname') }}" required>
                @error('maternalSurname')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>

            <div class="form-group">
              <label for="email">{{ __('Correo') }}</label>
              <div class="input-group mb-3">
                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="{{ __('Correo') }}" value="{{ old('email') }}" required>
                @error('email')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>

            <div class="form-group">
              <label for="password">{{ __('Contraseña') }}</label>
              <div class="input-group mb-3">
                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('Contraseña') }}" required>
                @error('password')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>

            <div class="form-group">
              <label for="password_confirmation">{{ __('Verificar contraseña') }}</label>
              <div class="input-group mb-3">
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="{{ __('Verificar contraseña') }}" required>
              </div>
            </div>

            <button type="button" id="next-btn" class="btn btn-primary mr-2">Siguiente Paso</button>
          </div>

          <!-- Sección Información Adicional -->
          <div id="additional-info-section" style="display: none;">
            <div class="form-group">
              <label for="codigo_postal">{{ __('Código Postal') }}</label>
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
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="d_asenta">{{ __('Colonia') }}</label>
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
              </div>

              <div class="form-group col-md-6">
                <label for="D_mnpio">{{ __('Municipio') }}</label>
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
              </div>
            </div>

            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="d_estado">{{ __('Estado') }}</label>
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
              </div>

              <div class="form-group col-md-6">
                <label for="d_ciudad">{{ __('Ciudad') }}</label>
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
              </div>
            </div>

            <div class="form-group">
              <label for="genero">{{ __('Seleccione su género') }}</label>
              <div class="input-group mb-3">
                <select id="genero" name="genero" class="form-control @error('genero') is-invalid @enderror">
                  <option value="">{{ __('Seleccione su género') }}</option>
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
            </div>

            <div class="form-group">
              <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms">
                  {{ __('I agree to the') }} <a href="#">{{ __('terms') }}</a>
                </label>
              </div>
            </div>

            <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


</body>
</html>
