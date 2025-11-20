<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guías Rápidas - PatitasOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 220px;
            background-color: transparent;
            color: black;
            padding: 20px 0;
            overflow-y: auto;
            z-index: 1000;
            border-left: 2px solid #cd4daaff;
            border-right: 15px solid #cd4daaff;
        }

        .sidebar-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 10px;
            font-style: italic;
            font-family: 'Georgia', serif;
            font-weight: bold;
            color: #0e0d0dff;
        }

        .sidebar-header .titulo-patitas {
            font-size: 40px;
            margin-bottom: 7px;
        }

        .sidebar-header img.logo-huella {
            width: 60px;
            height: 50px;
        }

        .sidebar a {
            color: black;
            padding: 10px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: 1rem;
        }

        .sidebar a img {
            width: 22px;
            height: 22px;
            margin-right: 10px;
        }

        .sidebar a:hover {
            background-color: #deb6d3ff;
            border-radius: 6px;
        }

        .content {
            flex: 1;
            padding: 20px;
            margin-left: 220px;
            overflow-y: auto;
        }

        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            transition: box-shadow 0.15s ease-in-out;
        }

        .card:hover {
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .timeline-step {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="titulo-patitas">Patitas</div>
            <img src="/imagenes/corazon.png" alt="Huella" class="logo-huella">
        </div>

        <a href="{{ route('publicaciones.index') }}"><img src="/imagenes/home.png"> Home</a>
        <a href="{{ route('publicaciones.create') }}"><img src="/imagenes/crear.png"> Crear</a>
        <a href="{{ route('buscar') }}"><img src="/imagenes/lupa.png"> Buscar</a>
        <a href="{{ route('notificaciones.index') }}"><img src="/imagenes/notificaciones.png"> Notificaciones</a>
        <a href="{{ route('mensajes.usuarios') }}"><img src="/imagenes/comentario.png"> Mensajes</a>
        <a href="{{ route('explorar') }}"><img src="/imagenes/mundial.png"> Explorar</a>
        <a href="{{ route('guias.rapidas') }}" style="background-color: #deb6d3ff; border-radius: 6px;"><img src="/imagenes/mundial.png"> Guías de uso</a>

        @auth
            @if (Auth::user()->tipo_usuario === 'refugio')
                <a href="{{ route('publicaciones.index') }}">
                    <img src="/icons/dog.png"> Publicar mascota en adopción
                </a>
            @endif
        @endauth

        @auth
            @if (Auth::user()->tipo_usuario === 'veterinaria')
                <div class="sidebar-item">
                    <button id="moreBtn" style="width: 100%; background: none; border: none; text-align: left; padding: 10px 20px; display: flex; align-items: center;">
                        <img src="/imagenes/mas.png" style="width: 22px; height: 22px; margin-right: 10px;"> Más
                    </button>
                </div>
            @endif
        @endauth

        <a href="{{ route('profile.edit') }}"><img src="/imagenes/usuario.png"> Perfil</a>

        <form method="POST" action="{{ route('logout') }}" style="margin-top: 20px; padding: 0 20px;">
            @csrf
            <button type="submit" style="background:none; border:none; color:black; text-align:left; padding:10px 0; width:100%; display:flex; align-items:center;">
                <img src="/imagenes/cerrar.png" style="width:22px; height:22px; margin-right:10px;"> Cerrar sesión
            </button>
        </form>
    </div>

    <!-- Contenido -->
    <div class="content">
        <div class="container py-4">
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-4">📖 Guías Rápidas de PatitasOS</h1>
                    <p class="lead">Selecciona tu tipo de usuario para ver la guía específica</p>

                    <div class="row g-4">
                        <!-- Dueños -->
                        <div class="col-md-4">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <div class="display-4 mb-3">👤</div>
                                    <h5 class="card-title">Dueños de Mascotas</h5>
                                    <p class="card-text">Guía para propietarios que buscan servicios y comunidad</p>
                                    <a href="{{ route('guias.dueno') }}" class="btn btn-primary">Ver Guía</a>
                                </div>
                            </div>
                        </div>

                        <!-- Veterinarias -->
                        <div class="col-md-4">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <div class="display-4 mb-3">🏥</div>
                                    <h5 class="card-title">Veterinarias</h5>
                                    <p class="card-text">Guía completa para gestión de consulta veterinaria</p>
                                    <a href="{{ route('guias.veterinaria') }}" class="btn btn-success">Ver Guía</a>
                                </div>
                            </div>
                        </div>

                        <!-- Refugios -->
                        <div class="col-md-4">
                            <div class="card text-center h-100">
                                <div class="card-body">
                                    <div class="display-4 mb-3">🐕</div>
                                    <h5 class="card-title">Refugios</h5>
                                    <p class="card-text">Guía para gestión de adopciones y comunicación</p>
                                    <a href="{{ route('guias.refugio') }}" class="btn btn-warning">Ver Guía</a>
                                </div>
                            </div>
                        </div>
                    </div>

                
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>