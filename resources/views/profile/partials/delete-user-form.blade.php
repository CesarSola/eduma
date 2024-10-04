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
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirm-user-deletion">
        {{ __('Eliminar Cuenta') }}
    </button>

    <!-- Botón para desactivar cuenta -->
    <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#confirm-user-deactivation">
        {{ __('Desactivar Cuenta') }}
    </button>

    <!-- Modal para eliminar cuenta -->
    <div class="modal fade" id="confirm-user-deletion" tabindex="-1" role="dialog"
        aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-lg font-medium text-gray-900" id="confirmUserDeletionLabel">
                        {{ __('¿Estás seguro de que deseas eliminar tu cuenta?') }}
                    </h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán eliminados permanentemente. Por favor, ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.') }}
                    </p>
                    <form method="post" action="{{ route('profile.destroy') }}">
                        @csrf
                        @method('delete')
                        <div class="mt-6">
                            <x-input-label for="delete-password" value="{{ __('Contraseña') }}" class="sr-only" />
                            <x-text-input id="delete-password" name="password" type="password" class="mt-1 block w-100"
                                placeholder="{{ __('Contraseña') }}" />
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancelar') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Eliminar Cuenta') }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para desactivar cuenta -->
    <div class="modal fade" id="confirm-user-deactivation" tabindex="-1" role="dialog"
        aria-labelledby="confirmUserDeactivationLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="text-lg font-medium text-gray-900" id="confirmUserDeactivationLabel">
                        {{ __('¿Estás seguro de que deseas desactivar tu cuenta?') }}
                    </h2>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Una vez que tu cuenta esté desactivada, tendrás 30 días para reactivarla volviendo a iniciar sesión. Por favor, introduce tu contraseña para confirmar que deseas desactivar tu cuenta.') }}
                    </p>
                    <form method="post" action="{{ route('profile.deactivate') }}">
                        @csrf
                        @method('post')
                        <div class="mt-6">
                            <x-input-label for="deactivation-password" value="{{ __('Contraseña') }}"
                                class="sr-only" />
                            <x-text-input id="deactivation-password" name="password" type="password"
                                class="mt-1 block w-100" placeholder="{{ __('Contraseña') }}" />
                            <x-input-error :messages="$errors->userDeactivation->get('password')" class="mt-2" />
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancelar') }}</button>
                    <button type="submit" class="btn btn-danger">{{ __('Desactivar Cuenta') }}</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</section>
