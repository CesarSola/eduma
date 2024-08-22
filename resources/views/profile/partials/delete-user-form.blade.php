<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Configuración de la Cuenta') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Administra la configuración de tu cuenta, incluyendo la desactivación y eliminación.') }}
        </p>
    </header>

    <!-- Botón para eliminar cuenta -->
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Eliminar Cuenta') }}</x-danger-button>

    <!-- Botón para desactivar cuenta -->
    <x-secondary-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deactivation')"
    >{{ __('Desactivar Cuenta') }}</x-secondary-button>

    <!-- Modal para eliminar cuenta -->
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('¿Estás seguro de que deseas eliminar tu cuenta?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Por favor, ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="delete-password" value="{{ __('Contraseña') }}" class="sr-only" />

                <x-text-input
                    id="delete-password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Contraseña') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Eliminar Cuenta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>

    <!-- Modal para desactivar cuenta -->
    <x-modal name="confirm-user-deactivation" :show="$errors->userDeactivation->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.deactivate') }}" class="p-6">
            @csrf
            @method('post')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('¿Estás seguro de que deseas desactivar tu cuenta?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Una vez que tu cuenta esté desactivada, tendrás 30 días para reactivarla volviendo a iniciar sesión. Por favor, introduce tu contraseña para confirmar que deseas desactivar tu cuenta.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="deactivation-password" value="{{ __('Contraseña') }}" class="sr-only" />

                <x-text-input
                    id="deactivation-password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Contraseña') }}"
                />

                <x-input-error :messages="$errors->userDeactivation->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Desactivar Cuenta') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
