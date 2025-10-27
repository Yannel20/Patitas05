@extends('layouts.navigation')

@section('title', 'Buscar')

@section('content')
<style>
/* 🎨 Colores principales */
:root {
    --rosa: #efcad6ff;          /* rosado */
    --rosa-claro: #f7dce4ff;    /* rosado pastel */
    --lila: #d7c2f0ff;          /* morado lila */
    --lila-oscuro: #c6a7e8ff;   /* morado payulo */
}

/* 🔍 Contenedor general */
.container {
    max-width: 750px;
}

/* Barra de búsqueda más angosta y centrada */
.input-group {
    width: 80%;
    margin: 0 auto;
}

/* Botones principales (rosados) */
.btn-rosa {
    background-color: var(--rosa);
    border: none;
    color: black;
    transition: 0.2s;
}
.btn-rosa:hover {
    background-color: var(--lila-oscuro);
    color: black;
}

.btn-rosa-claro {
    background-color: var(--rosa-claro);
    border: none;
    color: black;
    transition: 0.2s;
}
.btn-rosa-claro:hover {
    background-color: var(--rosa);
    color: black;
}

/* Checkboxes más grandes y con texto en negrita */
.filtros label {
    font-size: 1.1rem;
    font-weight: 700;
    color: #333;
    margin-right: 20px;
}
.filtros input[type="checkbox"] {
    transform: scale(1.2);
    accent-color: var(--lila);
    margin-right: 6px;
}

/* Tarjetas */
.card {
    border: 1px solid #f1f1f1;
    border-radius: 10px;
    transition: transform 0.2s;
}
.card:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

/* Foto circular */
.card img {
    border: 3px solid var(--rosa-claro);
}

/* Título de secciones */
h2 {
    color: black;
}

/* 🔹 Botón "Ver perfil" y "Ver autor" - morado payulo */
.card .btn-outline-primary {
    background-color: var(--lila);
    border: none;
    color: black;
}
.card .btn-outline-primary:hover {
    background-color: var(--lila-oscuro);
    color: black;
}

/* 🔹 Botón "Chatear" sin color (solo borde gris claro) */
.card .btn-chat {
    background-color: transparent;
    border: 1px solid #ccc;
    color: black;
    transition: 0.2s;
}
.card .btn-chat:hover {
    background-color: #f5f5f5;
    border-color: #aaa;
    color: black;
}

/* Ajustes visuales */
.alert {
    border-radius: 10px;
}
</style>

<div class="container mt-4 mb-5">
    <h2 class="text-center mb-4 fw-bold fst-italic" style="font-family: 'Georgia', serif;">
        🔍 Búsqueda
    </h2>

    {{-- 🔍 Formulario de búsqueda --}}
    <form id="formBusqueda" method="GET" action="{{ route('buscar') }}" class="mb-4 text-center">
        <div class="input-group">
            <input type="text" name="q" class="form-control rounded-start" placeholder="Buscar..." value="{{ $query ?? '' }}">
            <button class="btn btn-rosa rounded-end" type="submit">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>

        {{-- 🧩 Filtros --}}
        <div class="mt-3 filtros d-flex justify-content-center flex-wrap">
            <label><input type="checkbox" name="filtros[]" value="usuario" {{ in_array('usuario', $filtros ?? []) ? 'checked' : '' }}> Usuario</label>
            <label><input type="checkbox" name="filtros[]" value="refugio" {{ in_array('refugio', $filtros ?? []) ? 'checked' : '' }}> Refugio</label>
            <label><input type="checkbox" name="filtros[]" value="veterinaria" {{ in_array('veterinaria', $filtros ?? []) ? 'checked' : '' }}> Veterinaria</label>
            <label><input type="checkbox" name="filtros[]" value="publicacion" {{ in_array('publicacion', $filtros ?? []) ? 'checked' : '' }}> Publicación</label>
            <label><input type="checkbox" name="filtros[]" value="campana" {{ in_array('campana', $filtros ?? []) ? 'checked' : '' }}> Campaña</label>
        </div>

        {{-- 💾 Opciones adicionales --}}
        @auth
        <div class="mt-4 d-flex flex-wrap justify-content-center gap-3">
            <button type="submit" class="btn btn-rosa">
                <i class="bi bi-search"></i> Buscar
            </button>

            {{-- Botón Guardar --}}
            <button type="button" id="btnGuardar" class="btn btn-rosa">
                <i class="bi bi-bookmark"></i> Guardar búsqueda
            </button>

            <a href="{{ route('busqueda.guardadas') }}" class="btn btn-rosa-claro">
                <i class="bi bi-folder2-open"></i> Ver mis búsquedas guardadas
            </a>
        </div>
        @endauth
    </form>

    {{-- 🧾 Resultados --}}
    @if(isset($resultados) && $resultados->count() > 0)
        <div class="row">
            @foreach($resultados as $item)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow-sm p-3 h-100 d-flex flex-column justify-content-between">

                        {{-- 🔹 Usuario --}}
                        @if($item instanceof \App\Models\User)
                            <div class="d-flex align-items-center">
                                @if($item->photo)
                                    <img src="{{ $item->photo }}" alt="Foto" class="rounded-circle me-3 shadow-sm" width="60" height="60" style="object-fit:cover;">
                                @else
                                    <div class="rounded-circle bg-light text-dark d-flex justify-content-center align-items-center me-3"
                                         style="width:60px; height:60px; font-weight:bold; font-size:22px;">
                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <h5 class="mb-0">{{ $item->name }}</h5>
                                    <small class="text-muted fst-italic">{{ ucfirst($item->tipo_usuario ?? 'Usuario') }}</small>
                                </div>
                            </div>
                            <div class="mt-3 d-flex justify-content-between">
                                <a href="{{ route('perfil.show', $item->id) }}" class="btn btn-outline-primary btn-sm">
                                    Ver perfil
                                </a>
                                @if($item->id !== Auth::id())
                                    <a href="{{ route('chat', $item->id) }}" class="btn btn-chat btn-sm">
                                        <i class="bi bi-chat"></i> Chatear
                                    </a>
                                @endif
                            </div>

                        {{-- 🔹 Publicación --}}
                        @elseif($item instanceof \App\Models\Publicacion)
                            <h5 class="fw-bold">{{ $item->titulo }}</h5>
                            <p class="text-muted small">{{ Str::limit($item->descripcion, 100) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-secondary">📅 {{ $item->created_at->format('d M Y') }}</small>
                                <a href="{{ route('perfil.show', $item->user_id) }}" class="btn btn-outline-primary btn-sm">
                                    Ver autor
                                </a>
                            </div>

                        {{-- 🔹 Campaña --}}
                        @elseif($item instanceof \App\Models\CampanaEsterilizacion)
                            <h5 class="fw-bold">🐾 Campaña de Esterilización</h5>
                            <p class="text-muted small">{{ Str::limit($item->descripcion, 100) }}</p>
                            <small class="text-secondary">
                                <b>Inicio:</b> {{ $item->fecha_inicio }}<br>
                                <b>Fin:</b> {{ $item->fecha_fin }}
                            </small>
                            <a href="{{ route('perfil.show', $item->user_id) }}" class="btn btn-outline-primary btn-sm mt-2">
                                Ver organizador
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-secondary text-center mt-4">
            No se encontraron resultados para tu búsqueda.
        </div>
    @endif
</div>

{{-- 🪄 Formulario oculto --}}
@auth
<form id="formGuardar" method="POST" action="{{ route('buscar.guardar') }}" style="display:none;">
    @csrf
    <input type="hidden" name="q" value="">
</form>

<script>
document.getElementById('btnGuardar').addEventListener('click', function () {
    const formBusqueda = document.getElementById('formBusqueda');
    const formGuardar = document.getElementById('formGuardar');
    formGuardar.querySelector('input[name="q"]').value = formBusqueda.querySelector('input[name="q"]').value;

    // limpiar filtros
    formGuardar.querySelectorAll('input[name="filtros[]"]').forEach(e => e.remove());

    // clonar checkboxes seleccionados
    formBusqueda.querySelectorAll('input[name="filtros[]"]:checked').forEach(chk => {
        const hidden = document.createElement('input');
        hidden.type = 'hidden';
        hidden.name = 'filtros[]';
        hidden.value = chk.value;
        formGuardar.appendChild(hidden);
    });

    formGuardar.submit();
});
</script>
@endauth
@endsection
