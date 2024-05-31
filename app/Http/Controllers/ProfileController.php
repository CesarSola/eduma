<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index()
    {
        // Realizar la solicitud a la API
        $response = Http::get('https://api.copomex.com/query/get_colonia_por_cp/97830?token=1a1e01a4-11bd-4a5d-a9b5-fe563db704ea');

        // Obtener los datos JSON de la respuesta
        $data = $response->json();

        // Pasar los datos a la vista 'profile.partials.update-information-form-blade'
        return view('profile.partials.update-information-form-blade', compact('data'));
    }

    public function edit(Request $request): View
    {
        $user = auth()->user();

        // Obtener el código postal del usuario
        $codigoPostal = $user->codpos;

        // Realizar la solicitud a la API para obtener las colonias
        $response = Http::get("https://api.copomex.com/query/get_colonia_por_cp/{$codigoPostal}?token=1a1e01a4-11bd-4a5d-a9b5-fe563db704ea");

        // Obtener los datos JSON de la respuesta
        $data = $response->json();

        // Pasar los datos a la vista 'profile.edit'
        return view('profile.edit', compact('data', 'user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Validar los datos del formulario principal
        $validatedData = $request->validated();

        // Obtener el usuario actual
        $user = $request->user();

        // Procesar la foto del perfil si se proporciona una nueva
        if ($request->hasFile('photo')) {
            // Eliminar la foto anterior si existe
            if ($user->image != null) {
                Storage::disk('images')->delete($user->image->path);
                $user->image->delete();
            }
            // Almacenar la nueva foto en el sistema de archivos con el nombre personalizado
            $user->image()->create([
                'path' => $request->file('photo')->store('users', 'images'),
            ]);
        }

        // Actualizar los campos del usuario
        $user->fill($validatedData);

        // Si el email ha sido modificado, establecer email_verified_at a null
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Guardar los cambios en el usuario
        $user->save();

        // Redireccionar a la página de edición de perfil con un mensaje de estado
        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
