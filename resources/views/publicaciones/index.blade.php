@extends('layouts.navigation')

@section('title', 'Publicaciones')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<style>
.hidden.sm\:flex-1.sm\:flex.sm\:items-center.sm\:justify-between { display: none !important; } 
body { background: #fafafa; font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, Arial; } 
.container-feed { max-width: 600px; margin: 30px auto; } 
.card { background: #fff; border: 1px solid #dbdbdb; border-radius: 12px; margin-bottom: 30px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.04); position: relative; } 
.card-header { display:flex; align-items:center; gap:12px; padding:12px 14px; justify-content: space-between; } 
.avatar { width:42px; height:42px; border-radius:50%; object-fit:cover; } 
.username { font-weight:600; color: #710f54ff; } 
.timestamp { color:#8e8e8e; font-size:13px; } 
.card-body { padding:12px 14px; } 
.actions { display:flex; align-items:center; gap:12px; margin-bottom:8px; } 
.btn-love, .btn-share, .btn-seguir { background:none; border:none; cursor:pointer; font-size:14px; display:inline-flex; align-items:center; gap:6px; padding:4px 6px; } 
.btn-love svg, .btn-share svg { width:30px; height:30px; } 
.btn-love.loved svg { fill:#c2185b; stroke:#c2185b; } 
.btn-share svg { stroke:#000000; fill:none; transform: translateY(9px); } 
.like-count, .btn-share span { font-weight:600; } 
.descripcion { margin:6px 0 10px; color:#222; } 
.comentarios-list .comentario { margin:6px 0; font-size:14px; } 
.comentario strong { margin-right:6px; } 
.comment-form textarea { width:100%; border-radius:8px; padding:8px; border:1px solid #ddd; resize:vertical; } 
.comment-form button { margin-top:8px; background:#e0afbfff; color:#000000; border:none; padding:6px 12px; border-radius:8px; font-weight:700; cursor:pointer; } 
.comment-form button:hover { background:#d6a1afff; } 
.card-footer { padding:10px 14px; color:#8e8e8e; font-size:13px; display:flex; justify-content: space-between; } 
.ver-todos-comentarios { cursor:pointer; color:#00509e; font-size:13px; display:inline-block; margin-top:4px; } 
.btn-seguir { background:#c6c4d9ff; color:#000000; border-radius:8px; padding:6px 12px; font-size:14px; font-weight:700; } 
.btn-seguir:hover { background:#9795b0ff; } 
.menu-publicacion { position:absolute; top:10px; right:10px; cursor:pointer; font-weight:bold; font-size:20px; } 
.menu-options { display:none; position:absolute; top:30px; right:10px; background:#fff; border:1px solid #ccc; border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1); z-index:10; } 
.menu-options button { display:block; width:100%; padding:8px 12px; border:none; background:none; cursor:pointer; text-align:left; } 
.menu-options button:hover { background:#f4cfd9; }  
.compartido { border:1px solid #e0afbfff; padding:8px; background:#f9f9f9; margin-top:6px; border-radius:8px; }
.media {
    display: block;
    width: 100%;
    height: auto;
    max-height: 400px;
    object-fit: contain;
    object-position: center;
    border-radius: 10px;
    background-color: #000;
}

</style>


<div class="container-feed">
  @foreach($publicaciones as $publicacion)
    <div class="card" data-publicacion-id="{{ $publicacion->id }}">
      <div class="card-header">
        <div style="display:flex;align-items:center;gap:12px">
          <a href="{{ route('perfil.show', $publicacion->user->id) }}">
              <img src="{{ $publicacion->user->photo ?? 'https://ui-avatars.com/api/?name=' . urlencode($publicacion->user->name) }}" alt="avatar" class="avatar">
          </a>
          <div>
            <a href="{{ route('perfil.show', $publicacion->user->id) }}" class="username">
              {{ $publicacion->user->name }}
            </a>
            <div class="timestamp">{{ $publicacion->created_at->diffForHumans() }}</div>
          </div>
        </div>

        @auth
            @if(auth()->user()->id === $publicacion->user_id)
                <div class="menu-publicacion">⋮
                    <div class="menu-options">
                        <button class="editar-publicacion" data-url="{{ route('publicaciones.edit', $publicacion) }}">Editar</button>
                        <button class="eliminar-publicacion" data-url="{{ route('publicaciones.destroy', $publicacion) }}">Eliminar</button>
                    </div>
                </div>
            @elseif(auth()->user()->id !== $publicacion->user->id)
                @php
                    $estaSiguiendo = auth()->user()->siguiendo->contains('id', $publicacion->user->id);
                @endphp
                <button class="btn-seguir" data-url="{{ route('usuarios.seguir', $publicacion->user->id) }}">
                    {{ $estaSiguiendo ? 'Siguiendo' : 'Seguir' }}
                    ({{ $publicacion->user->seguidores()->count() }})
                </button>
            @endif
        @endauth
      </div>

      {{-- Publicación compartida o normal --}}
      <div class="card-body">
        @if(isset($publicacion->compartidoPor) && $publicacion->compartidoPor)
            {{-- Usuario que compartió --}}
            <div class="descripcion"><strong>{{ $publicacion->compartidoPor->name }}</strong> compartió esta publicación:</div>

            {{-- Publicación original --}}
            <div class="compartido">
                <div><strong>{{ $publicacion->user->name }}</strong>: {{ $publicacion->descripcion }}</div>
                @if($publicacion->media)
                <img src="{{ Storage::disk('ccs')->url($publicacion->media) }}" class="media" alt="imagen de la publicación">


                @endif
            </div>
            @else
            {{-- Publicación normal --}}
            <div class="descripcion"><strong>{{ $publicacion->titulo }}</strong><br>{{ $publicacion->descripcion }}</div>
            @if($publicacion->media)
                <img src="{{ Storage::disk('ccs')->url($publicacion->media) }}" class="media" alt="imagen de la publicación">


            @endif
        @endif


        {{-- Acciones --}}
        <div class="actions">
          @auth
            {{-- Like --}}
            <button class="btn-love {{ $publicacion->reaccionesLove->contains('user_id', auth()->id()) ? 'loved' : '' }}"
                    data-url="{{ route('reacciones.love', $publicacion) }}">
              <svg viewBox="0 0 24 24" fill="none" stroke="#333" stroke-width="1.5">
                <path d="M20.8 6.6a5.4 5.4 0 0 0-7.6 0L12 7.8l-1.2-1.2a5.4 5.4 0 1 0-7.6 7.6L12 22.2l8.8-8.8a5.4 5.4 0 0 0 0-7.8z"/>
              </svg>
              <span class="like-count">{{ $publicacion->reaccionesLove->count() }}</span>
            </button>

            {{-- Compartir --}}
            <form class="share-form" data-url="{{ route('publicaciones.compartir', $publicacion) }}">
              @csrf
              <button class="btn-share" data-url="{{ route('publicaciones.compartir', $publicacion) }}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="40" height="40" fill="none" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <line x1="22" y1="2" x2="11" y2="13"></line>
                  <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                </svg>
                <span>Compartir ({{ $publicacion->compartidos->count() }})</span>
              </button>
            </form>
          @endauth
        </div>

        {{-- Comentarios --}}
        <div class="comentarios-list" data-limit="2">
          @foreach($publicacion->comentarios()->latest()->take(2)->get()->reverse() as $comentario)
            <div class="comentario"><strong>{{ $comentario->user->name }}</strong>: {{ $comentario->contenido }}</div>
          @endforeach

          @if($publicacion->comentarios()->count() > 2)
            <a href="javascript:void(0)" class="ver-todos-comentarios" data-id="{{ $publicacion->id }}" data-shown="false">
              Ver todos los comentarios ({{ $publicacion->comentarios()->count()-2 }})
            </a>
          @endif
        </div>

        @auth
          <form class="comment-form" data-url="{{ route('comentarios.store', $publicacion) }}">
            @csrf
            <textarea name="contenido" rows="2" placeholder="Escribe un comentario..." required></textarea>
            <button type="submit">Comentar</button>
          </form>
        @endauth
      </div>

      <div class="card-footer">
        <span>{{ $publicacion->created_at->format('d/m/Y H:i') }}</span>
      </div>
    </div>
  @endforeach
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Toggle menú editar/eliminar
    document.querySelectorAll('.menu-publicacion').forEach(menu => {
        menu.addEventListener('click', function(e){
            e.stopPropagation();
            const options = this.querySelector('.menu-options');
            options.style.display = (options.style.display === 'block') ? 'none' : 'block';
        });
    });
    document.addEventListener('click', function(){
        document.querySelectorAll('.menu-options').forEach(opt => opt.style.display = 'none');
    });

    // Editar publicación
    document.querySelectorAll('.editar-publicacion').forEach(btn => {
        btn.addEventListener('click', function(){
            window.location.href = this.dataset.url;
        });
    });

    // Eliminar publicación
    document.querySelectorAll('.eliminar-publicacion').forEach(btn => {
        btn.addEventListener('click', function(){
            if(confirm('¿Seguro que deseas eliminar esta publicación?')){
                fetch(this.dataset.url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept':'application/json',
                        'X-Requested-With':'XMLHttpRequest'
                    }
                })
                .then(resp=>resp.json())
                .then(data=>{
                    if(data.success){
                        this.closest('.card').remove();
                    }else{
                        alert('No se pudo eliminar');
                    }
                }).catch(err=>console.error(err));
            }
        });
    });

    // Likes AJAX
    document.querySelectorAll('.btn-love[data-url]').forEach(btn => {
        btn.addEventListener('click', function(e){
            e.preventDefault();
            fetch(this.dataset.url, {
                method:'POST',
                headers:{
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept':'application/json',
                    'X-Requested-With':'XMLHttpRequest',
                    'Content-Type':'application/json'
                },
                body: JSON.stringify({})
            })
            .then(resp=>resp.json())
            .then(data=>{
                this.classList.toggle('loved', data.liked);
                const countEl = this.querySelector('.like-count');
                if(countEl) countEl.textContent = data.count;
            }).catch(err=>console.error(err));
        });
    });

    // Seguir AJAX
    document.querySelectorAll('.btn-seguir').forEach(btn => {
        btn.addEventListener('click', function(){
            fetch(this.dataset.url, {
                method:'POST',
                headers:{
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept':'application/json',
                    'X-Requested-With':'XMLHttpRequest'
                }
            })
            .then(resp => resp.json())
            .then(data => {
                if(data.count !== undefined){
                    this.textContent = (data.siguiendo ? 'Siguiendo' : 'Seguir') + ` (${data.count})`;
                }
            })
            .catch(err => console.error(err));
        });
    });

    // Comentarios AJAX
    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            const textarea = this.querySelector('textarea[name="contenido"]');
            const contenido = textarea.value.trim();
            if(!contenido) return;

            const params = new URLSearchParams();
            params.append('contenido', contenido);

            fetch(this.dataset.url, {
                method:'POST',
                headers:{
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept':'application/json',
                    'X-Requested-With':'XMLHttpRequest',
                    'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'
                },
                body: params.toString()
            })
            .then(resp => resp.json())
            .then(data => {
                const card = this.closest('.card');
                const list = card.querySelector('.comentarios-list');

                const div = document.createElement('div');
                div.classList.add('comentario');
                div.innerHTML = `<strong>${data.user_name}</strong>: ${data.contenido}`;
                list.appendChild(div);

                textarea.value = '';
            })
            .catch(err => console.error(err));
        });
    });
    
  document.querySelectorAll('.share-form').forEach(form => {
        form.addEventListener('submit', function(e){
            e.preventDefault();
            const url = this.dataset.url;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(resp => resp.json())
            .then(data => {
                // Actualiza el contador de compartidos
                const span = this.querySelector('span');
                if (span) {
                    span.textContent = `Compartir (${data.count})`;
                }
                alert('✅ Publicación compartida correctamente');
            })
            .catch(err => console.error(err));
        });
    });

});
</script>

@endsection   