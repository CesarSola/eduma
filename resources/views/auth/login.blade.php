<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Estilos adicionales */
        body {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body >

    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-lg shadow-md overflow-hidden p-8">
            <!-- Título y Descripción -->
            <div class="text-left">
                <h3 class="text-lg font-bold text-neutral-600 leading-6 lg:text-4xl">Iniciar sesión</h3>
                <p class="mt-4 text-base text-gray-500">Inicia sesión y evalúate con nosotros.</p>
            </div>

            <!-- Formulario de inicio de sesión -->
            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Imagen personalizada -->
                <div class="flex justify-center">
                    <img src="{{ asset('assets/img/logo.jpeg') }}" alt="Imagen de login">
                </div>

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                    <input id="email" name="email" type="email" autocomplete="username" required autofocus
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Introduce tu correo electrónico" :value="old('email')" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                        placeholder="Introduce tu contraseña" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <input id="remember_me" type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        name="remember">
                    <label for="remember_me" class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</label>
                </div>

                <!-- Botón de inicio de sesión -->
                <div class="flex justify-center mt-4">
                    <button type="submit"
                        class="group relative w-72 flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Iniciar sesión
                    </button>
                </div>
            </form>

            <!-- Enlaces de contraseña olvidada y registro -->
            <div class="flex justify-between items-center mt-4">
                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-base font-medium text-gray-500 focus:outline-none hover:text-neutral-600 focus:text-blue-600 sm:text-sm">
                    ¿Olvidaste tu contraseña?
                </a>
                @endif
                <a href="{{ route('register') }}" class="text-base font-medium text-gray-500 focus:outline-none hover:text-neutral-600 focus:text-blue-600 sm:text-sm">
                    Registrarme
                </a>
            </div>
        </div>
    </div>

</body>

</html>
