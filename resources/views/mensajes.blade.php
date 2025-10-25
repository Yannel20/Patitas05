@extends('layouts.navigation')

@section('title', 'Mensajes')

@section('content')
<div class="container mt-4" style="max-width:600px;">
    
    {{-- 🔍 Buscador --}}
    <form method="GET" action="{{ route('mensajes.usuarios') }}" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Buscar usuario..." value="{{ $search ?? '' }}">
            <button class="btn btn-purple" type="submit">
                <i class="bi bi-search"></i>
            </button>
        </div>
    </form>

    {{-- 🔎 Resultados de búsqueda --}}
    @if(!empty($search))
        <h3 class="text-center mb-4 fw-bold fst-italic" style="font-family: 'Cursive', 'Georgia', serif; letter-spacing: 1px;">
            Más Cuentas
        </h3>
        <div class="row">
            @forelse($allUsers as $user)
                <div class="col-12 mb-3">
                    <div class="card d-flex flex-row align-items-center p-2 shadow-sm">
                        {{-- 📸 Foto de perfil o inicial --}}
                        @if($user->photo)
                            <img src="{{ $user->photo }}" 
                                 alt="Foto de perfil" 
                                 class="rounded-circle me-3 shadow-sm"
                                 width="50" height="50"
                                 style="object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-lightpink text-dark d-flex justify-content-center align-items-center me-3" 
                                 style="width:50px; height:50px; font-weight:bold; font-size:20px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif

                        <div class="flex-grow-1">
                            <a href="{{ route('perfil.show', $user->id) }}" class="text-decoration-none text-dark">
                                <h5 class="mb-0">{{ $user->name }}</h5>
                            </a>
                        </div>
                        <a href="{{ route('chat', $user->id) }}" class="btn btn-purple btn-sm">Chatear</a>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card p-3 text-center text-muted">
                        No se encontraron usuarios.
                    </div>
                </div>
            @endforelse
        </div>
    @endif

    {{-- 💬 Lista de mensajes --}}
    <h3 class="text-center mb-4 fw-bold fst-italic" style="font-family: 'Cursive', 'Georgia', serif; letter-spacing: 1px;">
        Mensajes
    </h3>

    <div class="row">
        @forelse($mainUsers as $user)
            <div class="col-12 mb-3">
                <div class="card d-flex flex-row align-items-center p-2 shadow-sm">
                    @if($user->photo)
                        <img src="{{ $user->photo }}" 
                             alt="Foto de perfil" 
                             class="rounded-circle me-3 shadow-sm"
                             width="50" height="50"
                             style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-lightpink text-dark d-flex justify-content-center align-items-center me-3" 
                             style="width:50px; height:50px; font-weight:bold; font-size:20px;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    @endif

                    <div class="flex-grow-1">
                        <a href="{{ route('perfil.show', $user->id) }}" class="text-decoration-none text-dark">
                            <h5 class="mb-0">{{ $user->name }}</h5>
                        </a>
                    </div>
                    <a href="{{ route('chat', $user->id) }}" class="btn btn-purple btn-sm">Chatear</a>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card p-3 text-center text-muted">
                    Aún no tienes chats ni sigues usuarios.
                </div>
            </div>
        @endforelse
    </div>
</div>

{{-- 🎨 Estilos --}}
<style>
.btn-purple {
    background-color: #d6caedff; 
    color: #000;
    border: none;
}
.btn-purple:hover {
    background-color: #836cb4ff; 
    color: #000;
}
.bg-lightpink {
    background-color: #ead6deff !important; 
}
</style>
@endsection
