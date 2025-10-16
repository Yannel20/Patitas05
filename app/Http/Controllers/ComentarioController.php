<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Publicacion;
use App\Notifications\NuevaActividadNotification;

class ComentarioController extends Controller
{
    public function store(Request $request, Publicacion $publicacion)
    {
        $request->validate([
            'contenido' => 'required|string|max:500',
        ]);

        // Crear el comentario
        $comentario = $publicacion->comentarios()->create([
            'user_id' => auth()->id(),
            'contenido' => $request->contenido,
        ]);

        // 🔔 Enviar notificación al dueño de la publicación
        if ($publicacion->user_id !== auth()->id()) { // No notificar si se comenta uno mismo
            $publicacion->user->notify(
                new NuevaActividadNotification(
                    'comentario',
                    ' comentó: "'.$request->contenido.'"',
                    auth()->user()
                )
            );
        }

        // Respuesta AJAX
        if ($request->ajax()) {
            return response()->json([
                'id' => $comentario->id,
                'user_name' => $comentario->user->name,
                'contenido' => $comentario->contenido,
            ]);
        }

        return redirect()->back();
    }
}
