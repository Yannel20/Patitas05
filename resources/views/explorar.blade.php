@extends('layouts.navigation')

@section('title', 'Explorar')

@section('content')
<div class="explorar-container">
    <h1 class="titulo-principal">Explora y Ayuda 🐾</h1>

    <div class="tarjetas-grid">
        <!-- Campañas de Esterilización -->
        <div class="tarjeta">
            <div class="tarjeta-texto">
                <h2>Campañas de Esterilización</h2>
                <p>Participa en campañas locales para controlar la población y mejorar la vida de nuestras mascotas.</p>
            </div>
            <img src="{{ asset('imagenes/campana.jpg') }}" alt="Campañas de Esterilización">
        </div>

        <!-- Adopta una Mascota -->
        <div class="tarjeta">
            <div class="tarjeta-texto">
                <h2>Adopta una Mascota</h2>
                <p>Dale una segunda oportunidad a un amigo peludo que busca un hogar lleno de amor.</p>
            </div>
            <img src="{{ asset('imagenes/adopta.jpg') }}" alt="Adopta una Mascota">
        </div>

        <!-- Cuidado de la Mascota -->
        <div class="tarjeta">
            <div class="tarjeta-texto">
                <h2>Cuidado de la Mascota</h2>
                <p>Aprende consejos y buenas prácticas para mantener feliz y saludable a tu mascota.</p>
            </div>
            <img src="{{ asset('imagenes/cuidado.jpg') }}" alt="Cuidado de la Mascota">
        </div>

        <!-- Donar para Refugios -->
        <div class="tarjeta">
            <div class="tarjeta-texto">
                <h2>Donar para los Refugios</h2>
                <p>Contribuye con alimentos, medicinas o donaciones monetarias para los refugios.</p>
            </div>
            <img src="{{ asset('imagenes/comida.jpg') }}" alt="Donar para Refugios">
        </div>
    </div>
</div>

<style>
    /* General */
    body {
        background-color: #fafafa;
        font-family: 'Poppins', system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif;
    }

    .explorar-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 50px 20px;
        text-align: center;
    }

    .titulo-principal {
        font-size: 40px;
        font-weight: 700;
        color: #333;
        margin-bottom: 40px;
    }

    /* Grid de tarjetas */
    .tarjetas-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    /* Tarjeta */
    .tarjeta {
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .tarjeta:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    .tarjeta-texto {
        padding: 25px;
    }

    .tarjeta-texto h2 {
        font-size: 24px;
        color: #222;
        margin-bottom: 10px;
    }

    .tarjeta-texto p {
        color: #555;
        font-size: 15px;
        line-height: 1.5;
    }

    .tarjeta img {
        width: 100%;
        height: 250px;
        object-fit: cover;
        border-top: 1px solid #eee;
    }

    /* Responsive */
    @media (max-width: 900px) {
        .tarjetas-grid {
            grid-template-columns: 1fr;
        }
        .tarjeta img {
            height: 220px;
        }
    }
</style>
@endsection
