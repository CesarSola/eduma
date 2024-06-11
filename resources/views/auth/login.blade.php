<!DOCTYPE html>
<html lang="en">

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Estilos adicionales */
        body {
            background-color: #f2f2f2;
        }
    </style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inscribirse</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>

    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white rounded-lg shadow-md overflow-hidden p-8">
            <!-- Session Status -->
            <div>
                <!-- Aquí podrías insertar el código para moAstrar el mensaje de sesión si lo deseas -->
<section>
          <div>
            <div class="mt-3 text-left sm:mt-5">
              <div class="inline-flex items-center w-full">
                <h3 class="text-lg font-bold text-neutral-600 leading-6 lg:text-4xl">Iniciar sesión</h3>
              </div>
              <div class="mt-4 text-base text-gray-500">
                <p>Inicia sesión y evalúate con nosotros.</p>
              </div>
            </div>
          </div>

          <div class="mt-6 space-y-2">
            <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                @csrf

                <!-- Tu imagen personalizada -->
                <div class="flex justify-center">
                    <img src="{{ asset('assets/img/logo.jpeg') }}" alt="Imagen de login">
                </div>

              <label for="email" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
              <input id="email" name="email" type="email" autocomplete="username" required autofocus
              class="appearance-none rounded-md relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
              placeholder="Introduce tu correo electrónico" :value="old('email')" />
            </div>
            <div>
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
                <!-- Google Auth -->
                <div class="flex justify-center mt-4">
                    <a href="{{ url('/google-auth/redirect') }}" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="40" fill="currentColor"
                            class="bi bi-google" viewBox="0 0 16 16">
                            <path
                                d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z" />
                        </svg>
                    </a>
                </div>
         <!-- Login Button -->
         <div class="flex flex-col items-center mt-4 space-y-2">
            <button type="submit" class="group relative w-72 flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
              Iniciar sesión
            </button>
          </div>

          <!-- Forgot Password and Registration Links -->
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
          <!-- If the account is inactive, show a message with the email and a reactivation link -->
              @if($inactive ?? false)
              <div class="mb-3">
                  <p class="text-danger">This account is deactivated. Please reactivate it.</p>
                  <p class="text-muted">{{ __('Email') }}: {{ $email }}</p>
              </div>
              <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('profile.reactivate') }}">
                {{ __('Reactivate your account') }}
            </a>
              @endif
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>

</html>