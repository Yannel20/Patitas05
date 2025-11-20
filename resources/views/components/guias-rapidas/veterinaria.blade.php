<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guía Veterinarias - PatitasOS</title>
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
        <a href="{{ route('guias.rapidas') }}"><img src="/imagenes/mundial.png"> Guías de uso</a>

        <!-- Panel Más para Veterinarias -->
        <div class="sidebar-item">
            <button id="moreBtn" style="width: 100%; background: none; border: none; text-align: left; padding: 10px 20px; display: flex; align-items: center; color: black; font-size: 1rem;">
                <img src="/imagenes/mas.png" style="width: 22px; height: 22px; margin-right: 10px;"> Más
            </button>

            <div id="morePanel">
                <h6>Expedientes</h6>
                <a href="{{ route('duenos.index') }}">📋 Dueños</a>
                <a href="{{ route('mascotas.index') }}">🐾 Mascotas</a>
                <a href="{{ route('consultas.index') }}">🩺 Consultas</a>
                <a href="{{ route('historial.index') }}">📖 Historial Médico</a>
                <a href="{{ route('vacunaciones.index') }}">💉 Vacunaciones</a>
                <a href="{{ route('tratamientos.index') }}">💊 Tratamientos</a>

                <hr style="border-color: #495057;">
                <h6>Campañas</h6>
                <a href="{{ route('campanas.create') }}">📝 Publicar Campaña</a>
                <a href="{{ route('solicitudes.index') }}">📨 Solicitudes</a>
                <a href="{{ route('campanas.index') }}">📊 Control Campañas</a>
            </div>
        </div>

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
                    <h1 class="mb-4">🏥 Guía Rápida para Veterinarias</h1>
                    
                    <!-- Panel Más - Funcionalidades Principales -->
                    <div class="alert alert-info mb-4">
                        <h5>📍 Acceso Rápido: Panel "Más"</h5>
                        <p class="mb-0">Todas las funciones veterinarias están disponibles en el botón <strong>"Más"</strong> del menú lateral</p>
                    </div>

                    <div class="row g-4">
                        <!-- Gestión de Expedientes -->
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-header bg-primary text-white">
                                    <h6 class="mb-0">📋 Gestión de Expedientes</h6>
                                </div>
                                <div class="card-body">
                                    <h6>Dueños</h6>
                                    <p>Gestiona información de propietarios de mascotas</p>
                                    
                                    <h6>Mascotas</h6>
                                    <p>Administra historiales de pacientes animales</p>
                                    
                                    <h6>Consultas</h6>
                                    <p>Registro de visitas y diagnósticos</p>
                                </div>
                            </div>
                        </div>

                        <!-- Historial Médico -->
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-header bg-success text-white">
                                    <h6 class="mb-0">📖 Historial Médico</h6>
                                </div>
                                <div class="card-body">
                                    <h6>Vacunaciones</h6>
                                    <p>Control de esquemas de vacunación</p>
                                    
                                    <h6>Tratamientos</h6>
                                    <p>Seguimiento de medicamentos y terapias</p>
                                    
                                    <h6>Historial Completo</h6>
                                    <p>Registro médico integral por mascota</p>
                                </div>
                            </div>
                        </div>

                        <!-- Campañas y Comunicación -->
                        <div class="col-md-4">
                            <div class="card h-100">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0">📊 Campañas</h6>
                                </div>
                                <div class="card-body">
                                    <h6>Publicar Campañas</h6>
                                    <p>Crear promociones de salud preventiva</p>
                                    
                                    <h6>Solicitudes</h6>
                                    <p>Gestionar citas y consultas solicitadas</p>
                                    
                                    <h6>Control de Campañas</h6>
                                    <p>Monitoreo de participación y resultados</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Funciones Generales -->
                    <div class="row mt-4 g-4">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <img src="/imagenes/comentario.png" width="24" class="me-2"> Mensajes
                                    </h5>
                                    <p><strong>Comunicación con clientes:</strong></p>
                                    <ul>
                                        <li>Responder consultas de dueños</li>
                                        <li>Coordinar citas y seguimientos</li>
                                        <li>Enviar recordatorios de vacunas</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <img src="/imagenes/crear.png" width="24" class="me-2"> Crear
                                    </h5>
                                    <p><strong>Publicar contenido:</strong></p>
                                    <ul>
                                        <li>Consejos de salud animal</li>
                                        <li>Promociones de servicios</li>
                                        <li>Información educativa</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Flujo de Trabajo Recomendado -->
                    <div class="mt-5">
                        <h4 class="text-primary">🔄 Flujo de Trabajo Recomendado</h4>
                        <div class="timeline mt-3">
                            <div class="d-flex mb-3">
                                <div class="timeline-step bg-primary text-white rounded-circle d-flex align-items-center justify-content-center">1</div>
                                <div class="ms-3">
                                    <strong>Registrar Dueño y Mascota</strong>
                                    <p>Comienza creando expedientes en las secciones correspondientes</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="timeline-step bg-success text-white rounded-circle d-flex align-items-center justify-content-center">2</div>
                                <div class="ms-3">
                                    <strong>Programar Consulta</strong>
                                    <p>Usa la sección de consultas para agendar visitas</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="timeline-step bg-info text-white rounded-circle d-flex align-items-center justify-content-center">3</div>
                                <div class="ms-3">
                                    <strong>Actualizar Historial</strong>
                                    <p>Documenta vacunaciones y tratamientos aplicados</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="timeline-step bg-warning text-white rounded-circle d-flex align-items-center justify-content-center">4</div>
                                <div class="ms-3">
                                    <strong>Seguimiento</strong>
                                    <p>Usa mensajes para seguimiento post-consulta</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Consejos para Veterinarias -->
                    <div class="mt-5 p-4 bg-light rounded">
                        <h4 class="text-success">💡 Consejos para Veterinarias:</h4>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <strong>📝 Documentación completa</strong>
                                <p>Mantén historiales médicos detallados y actualizados</p>
                            </div>
                            <div class="col-md-4">
                                <strong>⏰ Respuesta rápida</strong>
                                <p>Atiende mensajes y solicitudes oportunamente</p>
                            </div>
                            <div class="col-md-4">
                                <strong>📢 Comunicación proactiva</strong>
                                <p>Usa campañas para educar y promover la salud preventiva</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('guias.rapidas') }}" class="btn btn-outline-primary me-2">← Volver a Guías</a>
                        <a href="{{ route('duenos.index') }}" class="btn btn-success">Comenzar con Expedientes →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Panel Más
        document.addEventListener('DOMContentLoaded', function() {
            const moreBtn = document.getElementById('moreBtn');
            const morePanel = document.getElementById('morePanel');

            if (moreBtn) {
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
    </script>
</body>
</html>