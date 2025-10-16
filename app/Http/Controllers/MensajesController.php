<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NuevaActividadNotification;

class MensajesController extends Controller
{
    /**
     * Mostrar listado de usuarios con los que chateas o sigues
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $user = auth()->user();

        // Usuarios que sigo
        $followingUsers = $user->siguiendo()->get();

        // Usuarios con los que ya tienes chat
        $chatUsers = User::where('id', '!=', $user->id)
            ->where(function($q) use ($user) {
                $q->whereIn('id', function($query) use ($user) {
                    $query->select('receiver_id')
                        ->from('messages')
                        ->where('user_id', $user->id);
                })
                ->orWhereIn('id', function($query) use ($user) {
                    $query->select('user_id')
                        ->from('messages')
                        ->where('receiver_id', $user->id);
                });
            })
            ->get();

        // Combinar seguidos + chat sin duplicados
        $mainUsers = $followingUsers->merge($chatUsers)->unique('id');

        // Buscar usuarios por nombre
        $allMatchingUsers = User::where('id', '!=', $user->id)
            ->where('name', 'like', "%{$search}%")
            ->get();

        // Separar los que sigues de los que no
        $followingMatching = $allMatchingUsers->intersect($followingUsers);
        $otherMatching = $allMatchingUsers->diff($followingUsers);

        // Combinar resultados finales
        $allUsers = $followingMatching->concat($otherMatching);

        return view('mensajes', compact('mainUsers', 'allUsers', 'search'));
    }

    /**
     * Enviar un mensaje y notificar al receptor
     */
    public function enviar(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'body' => 'required|string',
        ]);

        // Crear el mensaje
        $mensaje = Message::create([
            'user_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'body' => $request->body,
        ]);

        // Obtener el usuario receptor
        $receptor = User::find($request->receiver_id);

        // Evitar notificar a uno mismo
        if ($receptor->id !== auth()->id()) {
            // Crear una vista previa corta del mensaje
            $preview = strlen($request->body) > 30 
                ? substr($request->body, 0, 30) . '...' 
                : $request->body;

            // Enviar notificación
            $receptor->notify(
                new NuevaActividadNotification(
                    'mensaje',
                    'te envió un mensaje: "' . $preview . '"',
                    auth()->user()
                )
            );
        }

        return response()->json([
            'success' => true,
            'mensaje' => $mensaje
        ]);
    }
}
