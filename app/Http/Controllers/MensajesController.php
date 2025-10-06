<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class MensajesController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $user = auth()->user();

        // Usuarios que sigo
        $followingUsers = $user->siguiendo()->get();

        // Usuarios con los que ya tienes chat (usando tabla messages)
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
            })->get();

        // Combinar seguidos + chat sin duplicados
        $mainUsers = $followingUsers->merge($chatUsers)->unique('id');

        // Usuarios que coinciden con la búsqueda (excepto yo)
        $allMatchingUsers = User::where('id', '!=', $user->id)
                                ->where('name', 'like', "%{$search}%")
                                ->get();

        // Separar los que sigues de los que no
        $followingMatching = $allMatchingUsers->intersect($followingUsers);
        $otherMatching = $allMatchingUsers->diff($followingUsers);

        // Combinar resultados: primero los que sigues, luego el resto
        $allUsers = $followingMatching->concat($otherMatching);

        return view('mensajes', compact('mainUsers', 'allUsers', 'search'));
    }
}
