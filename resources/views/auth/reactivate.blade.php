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

<body>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-lg shadow-md overflow-hidden p-8">
            <!-- Imagen personalizada -->
            <div class="flex justify-center">
                <img src="{{ asset('assets/img/logo.jpeg') }}" alt="Imagen de login">
            </div>

            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    {{ __('Reactiva tu Cuenta') }}
                </h2>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('profile.reactivate') }}" method="POST">
                @csrf
                        <!-- Mensajes de error -->
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>¡Error!</strong> Correo electrónico o contraseña incorrectos.
        </div>
    @endif
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input id="email" type="email" name="email"
                            class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Introduce tu correo electrónico" :value="old('email')" required autofocus />
                    </div>
                    <br>
                    <div class="mt-4">
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <input id="password" type="password" name="password"
                            class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                            placeholder="Introduce tu contraseña" required />
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button>
                        {{ __('Reactivar Cuenta') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
