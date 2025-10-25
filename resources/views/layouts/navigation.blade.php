<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Mi App')</title>
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Sidebar */
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

        /* Encabezado Patitas */
        .sidebar-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: transparent;
            padding: 10px;
            margin: 0px;
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

        /* Activo */
        

        /* Sidebar items */
        .sidebar-item {
            position: relative;
        }

        #morePanel {
            position: fixed;
            left: 220px;
            top: 10px;
            background-color: #d5d4e0ff;    
            color: black;
            width: 350px;
            max-height: 80vh;
            overflow-y: auto;
            padding: 20px;
            border-radius: 8px;
            display: none;
            z-index: 2000;
        }

        #morePanel h6 {
            color: #0f0f0fff;
            margin-top: 10px;
            margin-bottom: 5px;
        }

        #morePanel a {
            color: black;
            text-decoration: none;
            padding: 5px 0;
            display: block;
        }

        #morePanel a:hover {
            background-color: #9492aeff;   
            border-radius: 4px;
            padding-left: 5px;
        }

        .content {
            flex: 1;
            padding: 20px;
            margin-left: 220px;
            overflow-y: auto;
        }

        .user-menu button {
            background-color: transparent;
            color: black;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 1rem;
            padding: 8px 16px;
        }

        .user-menu #dropdown {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #ccc;
            padding: 0.5rem;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            min-width: 160px;
            z-index: 9999;
            border-radius: 8px;
        }

        .user-menu #dropdown a,
        .user-menu #dropdown button {
            color: black;
            text-decoration: none;
            padding: 0.4rem;
            display: block;
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }

        .user-menu #dropdown a:hover,
        .user-menu #dropdown button:hover {
            background-color: #f0f0f0;
        }

        /* Botón Más */
        .sidebar-item button {
            width: 100%;
            background-color: transparent;
            border: none;
            color: black;
            text-align: left;
            padding: 10px 20px;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }

        .sidebar-item button:hover {
            background-color: #deb6d3ff; 
        }

        .sidebar-item button img {
            width: 22px;
            height: 22px;
            margin-right: 8px;
        }
    </style>
     @livewireStyles
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Encabezado -->
        <div class="sidebar-header">
            <div class="titulo-patitas">Patitas</div>
            <div class="underline"></div> 
            <img src="{{ asset('imagenes/corazon.png') }}" alt="Huella" class="logo-huella">
        </div>

        <!-- Menú principal con íconos -->
        <a href="{{ route('publicaciones.index') }}" class="{{ request()->routeIs('publicaciones.index') ? 'active' : '' }}">
            <img src="{{ asset('imagenes/home.png') }}" alt="Home"> Home
        </a>
        <a href="{{ route('publicaciones.create') }}" class="{{ request()->routeIs('publicaciones.create') ? 'active' : '' }}">
            <img src="{{ asset('imagenes/crear.png') }}" alt="Crear"> Crear
        </a>
        <a href="{{ route('consultas.create') }}" class="{{ request()->routeIs('consultas.create') ? 'active' : '' }}">
            <img src="{{ asset('imagenes/lupa.png') }}" alt="Buscar"> Buscar
        </a>
        <a href="{{ route('notificaciones.index') }}" class="{{ request()->routeIs('notificaciones.index') ? 'active' : '' }}">
            <img src="{{ asset('imagenes/notificaciones.png') }}" alt="Notificaciones"> Notificaciones
        </a>
        <a href="{{ route('mensajes.usuarios') }}" class="{{ request()->routeIs('mensajes.usuarios') ? 'active' : '' }}">
            <img src="{{ asset('imagenes/comentario.png') }}" alt="Mensajes"> Mensajes
        </a>
        <a href="{{ route('explorar') }}" class="{{ request()->routeIs('explorar') ? 'active' : '' }}">
            <img src="{{ asset('imagenes/mundial.png') }}" alt="Explorar"> Explorar
        </a>

        @auth
            @if (Auth::user()->tipo_usuario === 'refugio')
                <a href="{{ route('publicaciones.index') }}" class="{{ request()->routeIs('publicaciones.index') ? 'active' : '' }}">
                    <img src="{{ asset('icons/dog.png') }}" alt="Adopción"> Publicar mascota en adopción
                </a>
            @endif
        @endauth

        @auth
            @if (Auth::user()->tipo_usuario === 'veterinaria')
                <!-- Botón Más -->
                <div class="sidebar-item">
                    <button id="moreBtn">
                        <img src="{{ asset('imagenes/mas.png') }}" alt="Más"> Más
                    </button>

                    <div id="morePanel">
                        <h6>Expedientes</h6>
                        <a href="{{ route('duenos.index') }}">📋 Dueños</a>
                        <a href="{{ route('mascotas.index') }}">🐾 Mascotas</a>
                        <a href="{{ route('consultas.index') }}">🩺 Consultas</a>
                        <a href="{{ route('historial.index') }}">📖 Historial Médico</a>
                        <a href="{{ route('vacunaciones.index') }}">💉 Vacunaciones</a>
                        <a href="{{ route('tratamientos.index') }}">💊 Tratamientos</a>
                        <a href="{{ route('tratamientos.index') }}">⬇️ Descargar Reporte</a>
                        <a href="{{ route('tratamientos.index') }}">📧 Enviar Reporte</a>

                        <hr style="border-color: #495057;">

                        <h6>Campañas de Esterilización</h6>
                        <a href="{{ route('campanas.create') }}">📝 Publicar Campaña</a>
                        <a href="{{ route('solicitudes.index') }}">📨 Recibir solicitudes </a>
                        <a href="{{ route('campanas.index') }}">📊 Control Campañas</a>
                    </div>
                </div>
            @endif
        @endauth

        <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
            <img src="{{ asset('imagenes/usuario.png') }}" alt="Perfil"> Perfil
        </a>

        <!-- Cierre de sesión -->
        <form method="POST" action="{{ route('logout') }}" style="margin-top: 20px; padding: 0 20px;">
            @csrf
            <button type="submit" style="background: none; border: none; color: black; text-align: left; padding: 10px 0; width: 100%; display: flex; align-items: center;">
                <img src="{{ asset('imagenes/cerrar.png') }}" alt="Salir" style="width:22px; height:22px; margin-right:10px;">
                Cerrar sesión
            </button>
        </form>
    </div>

    <!-- Menú de usuario arriba a la derecha -->
    @auth
    <div class="user-menu" style="position: absolute; top: 10px; right: 10px; z-index: 9999;">
        <div style="position: relative;">
            <button id="dropdownToggle" onclick="toggleDropdown()">
                {{ Auth::user()->name }}
            </button>

            <div id="dropdown">
                <a href="{{ route('profile.edit') }}">Actualizar Perfil</a>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit">Cerrar sesión</button>
                </form>
            </div>
        </div>
    </div>
    @endauth

    <!-- Header -->
    @isset($header)
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            {{ $header }}
        </div>
    </header>
    @endisset

    <!-- Contenido principal -->
    <div class="content">
        @hasSection('content')
            @yield('content')
        @else
            {{ $slot }}
        @endif
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const moreBtn = document.getElementById('moreBtn');
            const morePanel = document.getElementById('morePanel');

            if(moreBtn){
                moreBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    morePanel.style.display = morePanel.style.display === 'none' ? 'block' : 'none';
                });
            }

            document.addEventListener('click', function(e) {
                if (morePanel && moreBtn && !moreBtn.contains(e.target) && !morePanel.contains(e.target)) {
                    morePanel.style.display = 'none';
                }
            });
        });

        // Dropdown usuario
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdown');
            dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
        }

        document.addEventListener('click', function (e) {
            const dropdown = document.getElementById('dropdown');
            const toggle = document.getElementById('dropdownToggle');
            if (dropdown && toggle && !toggle.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.style.display = 'none';
            }
        });
    </script>
@livewireScripts
</body>
</html>