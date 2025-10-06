@extends('layouts.navigation')

@section('title', 'Perfil de ' . $user->name)

@section('content')
<div class="container-feed">

    {{-- Encabezado --}}
    <div style="margin-bottom:20px; display:flex; justify-content:space-between; align-items:center;">
        <div>
            <h2>{{ $user->name }}</h2>
            <p class="text-muted">
                {{ $user->seguidores()->count() }} seguidores · 
                {{ $user->siguiendo()->count() }} siguiendo
            </p>
        </div>

        @auth
            @if(auth()->id() !== $user->id)
                <div style="display:flex; gap:10px;">
                    {{-- Botón seguir / dejar de seguir --}}
                    <button class="btn-seguir" data-url="{{ route('usuarios.toggleFollow', $user->id) }}">
                        {{ $siguiendo ? 'Siguiendo' : 'Seguir' }}
                    </button>

                    {{-- Botón mensaje --}}
                    <a href="{{ route('chat', $user->id) }}" class="btn-mensaje">
                        Mensaje
                    </a>
                </div>
            @endif
        @endauth
    </div>

    {{-- Publicaciones --}}
    <h4>Publicaciones</h4>
    @forelse($feed as $publicacion)
        <div class="card">
            <div class="card-header">
                <img src="{{ $publicacion->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($publicacion->user->name) }}" alt="avatar" class="avatar">
                <div>
                    <div class="username">{{ $publicacion->user->name }}</div>
                    <div class="timestamp">{{ $publicacion->created_at->diffForHumans() }}</div>
                </div>
            </div>

            <div class="card-body">
                <div class="descripcion">
                    <strong>{{ $publicacion->titulo }}</strong><br>
                    {{ $publicacion->descripcion }}
                </div>
            </div>
        </div>
    @empty
        <p>No tiene publicaciones todavía.</p>
    @endforelse

    {{-- Compartidos --}}
    <h4 class="mt-4">Compartidos</h4>
    @forelse($compartidos as $compartido)
        <div class="card">
            <div class="card-header">
                <img src="{{ $compartido->user->profile_photo_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($compartido->user->name) }}" alt="avatar" class="avatar">
                <div>
                    <div class="username">{{ $compartido->user->name }}</div>
                    <div class="timestamp">{{ $compartido->created_at->diffForHumans() }}</div>
                </div>
            </div>
            <div class="card-body">
                <small>Compartido de {{ $compartido->publicacionOriginal->user->name }}</small>
                <div class="descripcion">
                    <strong>{{ $compartido->publicacionOriginal->titulo }}</strong><br>
                    {{ $compartido->publicacionOriginal->descripcion }}
                </div>
            </div>
        </div>
    @empty
        <p>No ha compartido publicaciones.</p>
    @endforelse
</div>
@endsection