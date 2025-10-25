<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Mostrar el formulario del perfil del usuario.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Actualizar la información del perfil del usuario.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Validar la imagen antes de subirla
        $request->validate([
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        // 📸 Si hay una nueva foto
        if ($request->hasFile('photo')) {
            // Eliminar la anterior si existe (solo si era una ruta, no URL completa)
            if ($user->photo && str_contains($user->photo, 'profile-photos/')) {
                // Eliminamos del bucket CCS
                Storage::disk('ccs')->delete($user->photo);
            }

            // Guardamos la nueva en la carpeta "profile-photos"
            $path = $request->file('photo')->store('profile-photos', 'ccs');

            // La hacemos pública (por si el bucket es privado)
            Storage::disk('ccs')->setVisibility($path, 'public');

            // Obtenemos la URL pública
            $user->photo = Storage::disk('ccs')->url($path);
        }

        // Actualizamos nombre, email, etc.
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Eliminar la cuenta del usuario.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Opcional: borrar foto de S3 si existe
        if ($user->photo && str_contains($user->photo, 'profile-photos/')) {
            Storage::disk('ccs')->delete($user->photo);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
