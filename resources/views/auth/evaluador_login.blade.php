<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
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
        <!-- Formulario de Inicio de Sesión -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="text-center">
                            <h1 class="text-lg font-bold text-neutral-600 lg-text-4xl">Iniciar Sesión</h1>
                            <img src="{{ asset('assets/img/logo.jpeg') }}" alt="Logo"
                                style="width: 150px; margin-top: 20px;">
                        </div>
                        <form method="POST" action="{{ route('evaluadores.login') }}">
                            @csrf
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" required>
                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
