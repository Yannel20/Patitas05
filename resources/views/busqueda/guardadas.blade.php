@extends('layouts.navigation')

@section('title', 'Mis búsquedas guardadas')

@section('content')
<style>
/* 🎨 Paleta principal */
:root {
    --rosa: #f9e6ec;        /* rosado pastel muy suave */
    --rosa-borde: #efcad6ff;
    --lila: #d7c2f0ff;
}

/* 🔹 Contenedor general */
.container-guardadas {
    max-width: 600px;
    margin: 50px auto;
    position: relative;
    padding: 15px 20px;
    border-radius: 20px;
    background-color: white;
}

/* 🌸 Marco rosado-lila alrededor */
.container-guardadas::before {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 20px;
    border: 3px solid transparent;
    background: linear-gradient(135deg, var(--rosa-borde), var(--lila)) border-box;
    -webkit-mask:
        linear-gradient(#fff 0 0) padding-box, 
        linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    pointer-events: none;
}

/* 🔹 Tarjetas (cada búsqueda) */
.list-group-item {
    border-radius: 14px !important;
    margin-bottom: 10px;
    background-color: var(--rosa); /* 💗 Fondo rosado suave */
    border: 1px solid #f2dce2;
    box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    transition: transform 0.2s, box-shadow 0.2s;
}
.list-group-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

/* 🔸 Botones */
.btn-outline-primary {
    border-color: var(--lila);
    color: #5a4b8a;
}
.btn-outline-primary:hover {
    background-color: var(--lila);
    color: black;
}

.btn-outline-danger {
    border-color: var(--rosa-borde);
    color: #b84c6b;
}
.btn-outline-danger:hover {
    background-color: var(--rosa-borde);
    color: black;
}

/* 📝 Texto */
.list-group-item strong {
    font-size: 1.1rem;
    color: #333;
}
.list-group-item small {
    color: #555;
}

/* 🪞 Título */
h2 {
    color: #2c2c2c;
}
</style>

<div class="container-guardadas shadow-sm bg-white">
    <h2 class="text-center mb-4 fw-bold fst-italic" style="font-family:'Georgia', serif;">
        📁 Mis búsquedas guardadas
    </h2>

    @if($busquedas->count() > 0)
        <ul class="list-group shadow-sm">
            @foreach($busquedas as $b)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $b->termino ?: '(sin término)' }}</strong><br>
                        <small>
                            Filtros: {{ implode(', ', json_decode($b->filtros, true) ?: []) }}
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        {{-- 🔁 Repetir búsqueda --}}
                        <a href="{{ route('buscar', ['q' => $b->termino, 'filtros' => json_decode($b->filtros, true)]) }}"
                           class="btn btn-outline-primary btn-sm" title="Repetir búsqueda">
                            <i class="bi bi-arrow-repeat"></i>
                        </a>

                        {{-- 🗑️ Eliminar --}}
                        <form method="POST" action="{{ route('busqueda.eliminar', $b->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm" title="Eliminar">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <div class="alert alert-secondary text-center rounded-3">
            No tienes búsquedas guardadas.
        </div>
    @endif
</div>
@endsection
