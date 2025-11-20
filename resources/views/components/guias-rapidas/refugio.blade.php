<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Guía Refugios - PatitasOS</title>
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

        .feature-badge {
            background: linear-gradient(45deg, #ff6b6b, #ffa726);
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
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
        <a href="{{ route('guias.rapidas') }}"><img src="/imagenes/mundial.png"> Guías de uso</a>

        <!-- Función Exclusiva para Refugios -->
        <a href="{{ route('publicaciones.index') }}" style="background-color: #fff3cd; border-radius: 6px;">
            <img src="/icons/dog.png"> Publicar mascota en adopción
        </a>

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
                    <h1 class="mb-4">🐕 Guía Rápida para Refugios</h1>

                    <!-- Funcionalidad Especial -->
                    <div class="alert alert-warning mb-4">
                        <h5>🎯 Función Exclusiva para Refugios</h5>
                        <p class="mb-0">Como refugio, tienes acceso a la función especial: <strong>"Publicar mascota en adopción"</strong> en el menú lateral</p>
                    </div>

                    <div class="row g-4">
                        <!-- Gestión de Adopciones -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-warning text-dark">
                                    <h6 class="mb-0">🏠 Gestión de Adopciones</h6>
                                </div>
                                <div class="card-body">
                                    <h6>Publicar Mascotas <span class="feature-badge">EXCLUSIVO</span></h6>
                                    <p class="text-success">
                                        <strong>Función exclusiva disponible en tu menú</strong>
                                    </p>
                                    <ul>
                                        <li>Crear perfiles de mascotas disponibles</li>
                                        <li>Subir fotos y información detallada</li>
                                        <li>Especificar requisitos de adopción</li>
                                    </ul>
                                    
                                    <h6>Seguimiento de Procesos</h6>
                                    <ul>
                                        <li>Gestionar solicitudes de adopción</li>
                                        <li>Comunicarte con posibles adoptantes</li>
                                        <li>Coordinar visitas al refugio</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Comunicación y Visibilidad -->
                        <div class="col-md-6">
                            <div class="card h-100">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">📢 Comunicación y Visibilidad</h6>
                                </div>
                                <div class="card-body">
                                    <h6>Crear Publicaciones</h6>
                                    <p>Comparte noticias y actualizaciones del refugio</p>
                                    
                                    <h6>Mensajes Directos</h6>
                                    <p>Atiende consultas de posibles adoptantes</p>
                                    
                                    <h6>Explorar</h6>
                                    <p>Conecta con otros refugios y veterinarias</p>
                                    
                                    <h6>Notificaciones</h6>
                                    <p>Mantente al tanto de interacciones importantes</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Funciones de Comunicación -->
                    <div class="row mt-4 g-4">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <img src="/imagenes/comentario.png" width="24" class="me-2"> Mensajes
                                    </h5>
                                    <p><strong>Gestión de adopciones:</strong></p>
                                    <ul>
                                        <li>Responder a interesados</li>
                                        <li>Coordinar visitas</li>
                                        <li>Seguimiento post-adopción</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <img src="/imagenes/crear.png" width="24" class="me-2"> Crear
                                    </h5>
                                    <p><strong>Contenido del refugio:</strong></p>
                                    <ul>
                                        <li>Historias de mascotas rescatadas</li>
                                        <li>Eventos de adopción</li>
                                        <li>Necesidades del refugio</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">
                                        <img src="/imagenes/notificaciones.png" width="24" class="me-2"> Notificaciones
                                    </h5>
                                    <p><strong>Mantente informado:</strong></p>
                                    <ul>
                                        <li>Nuevos mensajes</li>
                                        <li>Interés en adopciones</li>
                                        <li>Actualizaciones importantes</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mejores Prácticas -->
                    <div class="mt-5 p-4 bg-light rounded">
                        <h4 class="text-success">🌟 Mejores Prácticas para Refugios</h4>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <strong>📸 Fotos de Calidad</strong>
                                <p>Usa imágenes claras y atractivas de las mascotas</p>
                            </div>
                            <div class="col-md-4">
                                <strong>📝 Descripciones Detalladas</strong>
                                <p>Incluye personalidad, necesidades especiales y historia</p>
                            </div>
                            <div class="col-md-4">
                                <strong>⏰ Respuesta Rápida</strong>
                                <p>Responde pronto a mensajes de interesados</p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <strong>🔍 Transparencia</strong>
                                <p>Sé honesto sobre el historial y necesidades de la mascota</p>
                            </div>
                            <div class="col-md-4">
                                <strong>🤝 Seguimiento</strong>
                                <p>Mantén contacto post-adopción para apoyo</p>
                            </div>
                            <div class="col-md-4">
                                <strong>📢 Colaboración</strong>
                                <p>Trabaja con veterinarias y otros refugios</p>
                            </div>
                        </div>
                    </div>

                    <!-- Checklist de Publicación -->
                    <div class="mt-4 p-4 border rounded">
                        <h5 class="text-primary">✅ Checklist para Publicar Mascotas</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Fotos claras desde diferentes ángulos</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Descripción completa de personalidad</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Información médica actualizada</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Requisitos de adopción claros</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Historial de rescate/comportamiento</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox">
                                    <label class="form-check-label">Información de contacto actualizada</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Proceso de Adopción -->
                    <div class="mt-5">
                        <h4 class="text-primary">🔄 Proceso de Adopción Recomendado</h4>
                        <div class="timeline mt-3">
                            <div class="d-flex mb-3">
                                <div class="timeline-step bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">1</div>
                                <div class="ms-3">
                                    <strong>Publicar Mascota</strong>
                                    <p>Crea un perfil atractivo con toda la información necesaria</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="timeline-step bg-success text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">2</div>
                                <div class="ms-3">
                                    <strong>Evaluar Interesados</strong>
                                    <p>Revisa mensajes y perfiles de posibles adoptantes</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="timeline-step bg-info text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">3</div>
                                <div class="ms-3">
                                    <strong>Entrevista y Visita</strong>
                                    <p>Coordina encuentros para evaluar compatibilidad</p>
                                </div>
                            </div>
                            <div class="d-flex mb-3">
                                <div class="timeline-step bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">4</div>
                                <div class="ms-3">
                                    <strong>Seguimiento Post-Adopción</strong>
                                    <p>Mantén contacto para asegurar adaptación exitosa</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <a href="{{ route('guias.rapidas') }}" class="btn btn-outline-primary me-2">← Volver a Guías</a>
                        <a href="{{ route('publicaciones.create') }}" class="btn btn-warning">Publicar Mascota →</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>