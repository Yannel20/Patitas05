import './bootstrap';

// Esperar que Livewire esté listo
document.addEventListener('livewire:load', () => {
    // Obtener el ID del usuario autenticado desde meta tag o variable global
    const userIdMeta = document.querySelector('meta[name="user-id"]');
    if (!userIdMeta) {
        console.error('❌ No se encontró meta[name="user-id"] en el layout.');
        return;
    }

    const userId = userIdMeta.content;

    console.log('🔌 Escuchando canal privado: chat.' + userId);

    // Suscribirse al canal privado del usuario actual
    window.Echo.private(`chat.${userId}`)
        .listen('MessageSent', (e) => {
            console.log('💬 Nuevo mensaje recibido:', e);

            // Notificar a Livewire que debe actualizar la lista de mensajes
            Livewire.dispatch('message-received');
        });
});
