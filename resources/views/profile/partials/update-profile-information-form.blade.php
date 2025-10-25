<div class="container py-5">
    <div class="card shadow-lg border-0 mx-auto" style="max-width: 600px; border-radius: 15px;">
        <div class="card-body">
             <h2 class="text-center fw-bold mb-3" style="color:#212529">Información del perfil</h2>

            <p class="text-center text-muted mb-4">
                Actualiza tu información personal y dirección de correo.
            </p>

            <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('patch')

                {{-- Imagen de perfil --}}
                <div class="text-center mb-4">
                    @if ($user->photo)
                        <img src="{{ $user->photo }}" 
                            class="rounded-circle shadow mb-3" 
                            width="120" height="120" 
                            alt="Foto de perfil">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=cd4daa&color=fff"
                            class="rounded-circle shadow mb-3" 
                            width="120" height="120" 
                            alt="Avatar">
                    @endif


                    <div class="mb-3">
                        <label for="photo" class="form-label fw-semibold">Foto de Perfil</label>
                        <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
                        @error('photo') 
                            <div class="text-danger small">{{ $message }}</div> 
                        @enderror
                    </div>
                </div>

                {{-- Nombre --}}
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nombre</label>
                    <input type="text" id="name" name="name" 
                           class="form-control" 
                           value="{{ old('name', $user->name) }}" required>
                    @error('name') 
                        <div class="text-danger small">{{ $message }}</div> 
                    @enderror
                </div>

                {{-- Correo --}}
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">Correo Electrónico</label>
                    <input type="email" id="email" name="email" 
                           class="form-control" 
                           value="{{ old('email', $user->email) }}" required>
                    @error('email') 
                        <div class="text-danger small">{{ $message }}</div> 
                    @enderror
                </div>

                {{-- Tipo de usuario --}}
                <div class="mb-3">
                    <label for="tipo_usuario" class="form-label fw-semibold">Tipo de Usuario</label>
                    <input type="text" id="tipo_usuario" name="tipo_usuario" 
                           class="form-control bg-light" 
                           value="{{ $user->tipo_usuario }}" readonly>
                </div>

                {{-- Botón --}}
                <div class="text-center mt-4">
                    <button class="btn btn-lg text-white px-5 fw-semibold" style="background-color:#cd4daa;">
                        Guardar Cambios
                    </button>

                    @if (session('status') === 'profile-updated')
                        <p class="text-success mt-3 fw-semibold">Guardado correctamente.</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>
