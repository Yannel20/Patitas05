<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\NuevaActividadNotification;

class UserController extends Controller
{
    // Seguir / dejar de seguir a un usuario
    public function seguir(User $user)
    {
        $authUser = auth()->user();

        // Evitar seguirse a sí mismo
        if ($authUser->id === $user->id) {
            return response()->json(['error' => 'No puedes seguirte a ti mismo.'], 400);
        }

        // Si ya sigue al usuario, dejar de seguir
        if ($authUser->siguiendo()->where('seguido_id', $user->id)->exists()) {
            $authUser->siguiendo()->detach($user->id); 
            $siguiendo = false;
        } else {
            // Seguir al usuario
            $authUser->siguiendo()->attach($user->id);
            $siguiendo = true;

            // 🔔 Notificar al usuario seguido
            $user->notify(
                new NuevaActividadNotification(
                    'seguir',
                    ' comenzó a seguirte.',
                    $authUser
                )
            );
        }

        return response()->json([
            'siguiendo' => $siguiendo,
            'count' => $user->seguidores()->count()
        ]);
    }

    // Opcional: mostrar perfil de usuario
    public function perfil(User $user)
    {
        $authUser = auth()->user();
        $siguiendo = $authUser->siguiendo()->where('seguido_id', $user->id)->exists();

        return view('usuarios.perfil', [
            'user' => $user,
            'siguiendo' => $siguiendo,
            'seguidores_count' => $user->seguidores()->count(),
            'siguiendo_count' => $user->siguiendo()->count(),
        ]);
    }
}
