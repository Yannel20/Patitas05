<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guía Dueños - PatitasOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Mismos estilos que la guía principal */
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
        <a href="{{ route('guias.rapidas') }}"><img src="/imagenes/contacto.png"> Guías de uso</a>

        @auth
            @if (Auth::user()->tipo_usuario === 'refugio')
                <a href="{{ route('publicaciones.index') }}">
                    <img src="/icons/dog.png"> Publicar mascota en adopción
                </a>
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
                    <h1 class="mb-4">📚 Guía Rápida para Dueños de Mascotas</h1>
                    
                    <div class="row g-4">
                        <!-- Sección Home -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <img src="/imagenes/home.png" width="24" class="me-2"> Home
                                    </h5>
                                    <p class="card-text">
                                        <strong>Función:</strong> Ver todas las publicaciones recientes de la comunidad
                                    </p>
                                    <ul>
                                        <li>Publicaciones de mascotas en adopción</li>
                                        <li>Consejos de otras mascotas</li>
                                        <li>Noticias de refugios y veterinarias</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Buscar -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <img src="/imagenes/lupa.png" width="24" class="me-2"> Buscar
                                    </h5>
                                    <p class="card-text">
                                        <strong>Función:</strong> Encontrar mascotas, servicios y recursos
                                    </p>
                                    <ul>
                                        <li>Buscar mascotas para adoptar</li>
                                        <li>Encontrar veterinarias cercanas</li>
                                        <li>Localizar refugios de confianza</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Mensajes -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <img src="/imagenes/comentario.png" width="24" class="me-2"> Mensajes
                                    </h5>
                                    <p class="card-text">
                                        <strong>Función:</strong> Comunicarte con otros usuarios
                                    </p>
                                    <ul>
                                        <li>Contactar con refugios</li>
                                        <li>Consultar a veterinarias</li>
                                        <li>Coordinación de adopciones</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Sección Explorar -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <img src="/imagenes/mundial.png" width="24" class="me-2"> Explorar
                                    </h5>
                                    <p class="card-text">
                                        <strong>Función:</strong> Descubrir nuevos contenidos y servicios
                                    </p>
                                    <ul>
                                        <li>Ver mascotas destacadas</li>
                                        <li>Descubrir servicios veterinarios</li>
                                        <li>Explorar campañas de adopción</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Consejos Rápidos -->
                    <div class="mt-5 p-4 bg-light rounded">
                        <h4 class="text-success">💡 Consejos para Dueños:</h4>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <strong>🔄 Actualiza tu perfil</strong>
                                <p>Mantén tu información actualizada para mejores recomendaciones</p>
                            </div>
                            <div class="col-md-4">
                                <strong>📞 Contacta servicios</strong>
                                <p>Usa mensajes para consultar con veterinarias y refugios</p>
                            </div>
                            <div class="col-md-4">
                                <strong>🔔 Activa notificaciones</strong>
                                <p>Recibe alertas sobre servicios cerca de ti</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('guias.rapidas') }}" class="btn btn-outline-primary me-2">← Volver a Guías</a>
                        <a href="{{ route('publicaciones.index') }}" class="btn btn-primary">Ir al Home →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>