<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NuevaActividadNotification extends Notification
{
    use Queueable;

    public $tipo;       // 'like', 'comentario', 'mensaje', 'publicacion', 'campana'
    public $detalle;    // texto o datos que quieras mostrar
    public $user;       // quien genera la acción

    public function __construct($tipo, $detalle, $user)
    {
        $this->tipo = $tipo;
        $this->detalle = $detalle;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'tipo' => $this->tipo,
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'detalle' => $this->detalle,
        ];
    }
}
