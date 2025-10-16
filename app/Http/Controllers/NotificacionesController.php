<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificacionesController extends Controller
{
    // Mostrar todas las notificaciones del usuario logueado
    public function index()
    {
        $user = auth()->user();
        $notificaciones = $user->notifications()->latest()->get(); // todas
        $noLeidas = $user->unreadNotifications()->count();

        return view('notificaciones.index', compact('notificaciones', 'noLeidas'));
    }

    // Marcar una notificación como leída
    public function marcarComoLeida($id)
    {
        $notificacion = auth()->user()->notifications()->where('id', $id)->first();
        if ($notificacion) {
            $notificacion->markAsRead();
        }

        return back();
    }

    // Marcar todas como leídas
    public function marcarTodasComoLeidas()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
}
