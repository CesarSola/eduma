<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\CodigoPostal;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */


    public function edit(Request $request)
    {
        $codigosPostales = CodigoPostal::all(); // Obtener todos los códigos postales
        return view('profile.edit', [
            'user' => $request->user(),
            'codigosPostales' => $codigosPostales, // Pasar los códigos postales a la vista
        ]);
    }

    /**
     * Update the user's profile information.
     */
   /**
 * Update the user's profile information.
 */
/**
 * Update the user's profile information.
 */
public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // Actualizar los campos de perfil del usuario
    $user->fill($request->validated());

    // Obtener el género del formulario y asignarlo al usuario
    $user->genero = $request->input('genero');

    // Obtener el apellido del formulario y asignarlo al usuario
    $user->secondName = $request->input('secondName');
    $user->maternalSurname = $request->input('maternalSurname');
    $user->paternalSurname = $request->input('paternalSurname');
    $user->calle_avenida = $request->input('calle_avenida');
    $user->numext = $request->input('numext');
    $user->age= $request->input('age');
    $user->phone= $request->input('phone');

    // Si se actualizó el email, restablecer la verificación
    if ($user->isDirty('email')) {
        $user->email_verified_at = null;
    }
    $userName = str_replace(' ', '_', $user->name . '_' . $user->paternalSurname);

    // Validar y almacenar la fotografía digital si se ha enviado una
    if ($request->hasFile('foto')) {
        // Obtener el archivo de la solicitud
        $foto = $request->file('foto');

        // Almacenar la fotografía en la carpeta correspondiente con el nombre de usuario
        $fotoPath = $foto->storeAs('public/images/users/' . $userName, 'Foto.' . $foto->extension());

        // Asignar la ruta de la foto al usuario
        $user->foto = $fotoPath;
    }

    // Guardar los cambios en el usuario en la base de datos

    // Obtener los datos de dirección del formulario
    $codigoPostal = CodigoPostal::where('d_codigo', $request->input('codigo_postal'))->first();

    // Asignar los datos de dirección del código postal al usuario si se encuentra

        $user->d_codigo = $codigoPostal->d_codigo; // Asegúrate de asignar el código postal
        $user->d_asenta = $codigoPostal->d_asenta;
        $user->D_mnpio = $codigoPostal->D_mnpio;
        $user->d_estado = $codigoPostal->d_estado;
        $user->d_ciudad = $codigoPostal->d_ciudad;


    // Guardar los cambios en la base de datos
    $user->save();

    // Redirigir de vuelta al formulario de edición de perfil con un mensaje de éxito
    return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
