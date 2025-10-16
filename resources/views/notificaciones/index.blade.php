@extends('layouts.navigation')

@section('title', 'Notificaciones')

@section('content')
<div class="container mt-4" style="max-width:700px;">
    <h2 class="mb-4 fw-bold">🔔 Notificaciones ({{ $noLeidas }} sin leer)</h2>

    <form action="{{ route('notificaciones.leer.todas') }}" method="POST" class="mb-4">
        @csrf
        <button type="submit" class="btn btn-purple btn-sm">Marcar todas como leídas</button>
    </form>

    @forelse($notificaciones->take(15) as $notification)
        @php
            $data = $notification->data ?? [];
            $usuario = $data['user_name'] ?? 'Alguien';
            $detalle = $data['detalle'] ?? '';
            $tipo = $data['tipo'] ?? '';

            // Definir color e ícono según tipo
            $tipos = [
                'like' => ['color' => 'blue-light', 'icon' => '❤️'], 
                'comentario' => ['color' => 'pink', 'icon' => '💬'], 
                'compartido' => ['color' => 'pink-light', 'icon' => '🔁'], 
                'mensaje' => ['color' => 'blue', 'icon' => '📩'],
                'publicacion' => ['color' => 'green-light', 'icon' => '📢'],
                'seguir' => ['color' => 'purple-light', 'icon' => '👥'], 
                'campana' => ['color' => 'dark', 'icon' => '🐾'],
            ];

            $color = $tipos[$tipo]['color'] ?? 'light';
            $icon = $tipos[$tipo]['icon'] ?? '🔔';

            // Enlace según tipo de notificación
            $link = match($tipo) {
                'like', 'comentario', 'compartido', 'seguir' => route('perfil.show', $data['user_id']),
                'mensaje' => route('chat', $data['user_id']),
                'publicacion' => route('publicaciones.index'),
                default => '#'
            };
        @endphp

        <div class="card d-flex flex-row align-items-center p-3 mb-3 shadow-sm border-0 {{ $notification->read_at ? '' : 'border-3 border-primary' }}">
            <div class="rounded-circle bg-{{ $color }} text-white d-flex justify-content-center align-items-center me-3" style="width:45px; height:45px; font-size:22px;">
                {{ $icon }}
            </div>
            <div class="flex-grow-1">
                <a href="{{ $link }}" class="text-decoration-none text-dark">
                    <strong>{{ $usuario }}</strong> {{ $detalle }}
                </a>
                <div class="text-muted" style="font-size: 0.85rem;">
                    {{ $notification->created_at->format('d/m/Y H:i') }}
                </div>
            </div>
            <form action="{{ route('notificaciones.leer', $notification->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-pink btn-sm">Marcar leída</button>
            </form>
        </div>
    @empty
        <div class="card p-3 text-center text-muted shadow-sm">
            No tienes notificaciones.
        </div>
    @endforelse
</div>

<style>
.btn-purple {
    background-color: #d6caedff; 
    color: #000;
    border: none;
}
.btn-purple:hover {
    background-color: #836cb4ff; 
    color: #fff;
}

/* Colores personalizados */
.bg-pink-light { background-color: #f5d6e0 !important; }
.bg-pink { background-color: #e296aeff !important; }
.bg-purple-light { background-color: #c9b2e0 !important; }
.bg-green-light { background-color: #a4a5c2ff !important; }
.bg-blue-light { background-color: #a8d8f5 !important; } 
.bg-blue { background-color: #a5b7edff !important; }

/* Botón rosadito */
.btn-pink {
    background-color: #ebdadfff;
    color: #000;
    border: none;
}
.btn-pink:hover {
    background-color: #fa6aabff;
    color: #000;
}
</style>
@endsection
