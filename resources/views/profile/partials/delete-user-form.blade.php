<div class="container py-5">
    <div class="card shadow-lg border-0 mx-auto" style="max-width: 600px; border-radius: 15px;">
        <div class="card-body text-center">
            <h2 class="fw-bold mb-3" style="color:#212529;">Eliminar Cuenta</h2>
            <p class="mb-4" style="color:#212529;">
                Una vez que elimines tu cuenta, todos tus recursos y datos serán eliminados permanentemente.  
                Antes de hacerlo, descarga cualquier dato o información que desees conservar.
            </p>

            <!-- Botón para abrir modal -->
            <button type="button" 
                class="btn mt-4 px-4 py-2 text-white fw-semibold"
                style="background-color:#cd4daa;"
                data-bs-toggle="modal" 
                data-bs-target="#confirmDeleteModal">
                Eliminar Cuenta
            </button>
        </div>
    </div>
</div>

<!-- Modal de confirmación -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header" style="background-color:#cd4daa;">
                <h5 class="modal-title text-white fw-bold" id="confirmDeleteLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-body text-center" style="color:#212529;">
                    <p class="mb-3 fw-semibold">
                        Una vez que elimines tu cuenta, <span class="text-danger fw-bold">no podrás recuperarla.</span>  
                        Por favor, introduce tu contraseña para confirmar.
                    </p>

                    <div class="mb-3 text-start">
                        <label for="password" class="form-label fw-semibold" style="color:#212529;">Contraseña</label>
                        <input type="password" id="password" name="password" 
                               class="form-control" 
                               placeholder="Ingresa tu contraseña" required>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" 
                        class="btn text-white px-4 fw-semibold" 
                        style="background-color:#cd4daa;">
                        Eliminar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
