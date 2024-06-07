<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\CodigoPostal;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $codigosPostales = CodigoPostal::all(); // Obtener todos los códigos postales
        return view('profile.edit', [
            'user' => $request->user(),
            'codigosPostales' => $codigosPostales, // Pasar los códigos postales a la vista
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Actualizar los campos de perfil del usuario
        $user->fill($request->validated());

        // Obtener los valores del formulario y asignarlos al usuario
        $user->secondName = $request->input('secondName');
        $user->paternalSurname = $request->input('paternalSurname');
        $user->maternalSurname = $request->input('maternalSurname');
        $user->age = $request->input('age');
        $user->calle_avenida = $request->input('calle_avenida');
        $user->numext = $request->input('numext');
        $user->d_codigo = $request->input('codpos');
        $user->d_asenta = $request->input('colonia');
        $user->d_estado = $request->input('estado');
        $user->d_ciudad = $request->input('ciudad');
        $user->D_mnpio = $request->input('municipio');
        $user->phone = $request->input('phone');

        // Si se actualizó el email, restablecer la verificación
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $userName = str_replace(' ', '_', $user->name . '_' . $user->paternalSurname);

        // Validar y almacenar la fotografía digital si se ha enviado una
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $fotoPath = $foto->storeAs('public/images/users/' . $userName, 'Foto.' . $foto->extension());
            $user->foto = $fotoPath;
        }

        // Guardar los cambios en la base de datos
        $user->save();

        // Redirigir de vuelta al formulario de edición de perfil con un mensaje de éxito
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

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
