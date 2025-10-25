

<div class="container py-5">
    <div class="card shadow-lg border-0 mx-auto" style="max-width: 600px; border-radius: 15px;">
        <div class="card-body">
            <h2 class="text-center fw-bold mb-3" style="color:#212529">Actualizar Contraseña</h2>
            <p class="text-center text-muted mb-4">
                Asegúrate de que tu cuenta esté utilizando una contraseña larga y aleatoria para mantenerla segura.
            </p>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                @method('put')

                {{-- Contraseña actual --}}
                <div class="mb-3">
                    <label for="current_password" class="form-label fw-semibold">Contraseña actual</label>
                    <input type="password" id="current_password" name="current_password" class="form-control" required autocomplete="current-password">
                    @error('current_password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nueva contraseña --}}
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">Nueva contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password">
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirmar contraseña --}}
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirmar contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password">
                    @error('password_confirmation')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Botón guardar --}}
                <div class="text-center">
                    <button type="submit" class="btn px-5 text-white fw-semibold" style="background-color:#cd4daa;">
                        Guardar Cambios
                    </button>

                    @if (session('status') === 'password-updated')
                        <p class="text-success fw-semibold mt-3">Guardado correctamente.</p>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>


