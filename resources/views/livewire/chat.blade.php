<div style="max-width:600px; margin:0 auto;">

    <h1 style="text-align:center; font-weight:bold; font-style:italic; font-family:'Brush Script MT', 'Lucida Handwriting';">
        Chat con {{ \App\Models\User::find($receiverId)->name }}
    </h1>

    <!-- Contenedor de mensajes -->
    <div id="messagesContainer" 
         style="height:400px; overflow-y:auto; border:1px solid #ccc; padding:10px; background:#f9f9f9; margin-bottom:10px; display:flex; flex-direction:column-reverse;">
        
        @foreach($chatMessages as $message)
            <div style="margin-bottom:14px; display:flex; flex-direction:column; {{ $message->user_id === auth()->id() ? 'align-items:flex-end;' : 'align-items:flex-start;' }}">
                
                <!-- Nombre del usuario -->
                <div style="font-size:0.8rem; font-weight:bold; margin-bottom:4px; color:#000;">
                    {{ $message->user->name }}
                </div>

                <!-- Burbuja del mensaje -->
                <div style="
                    max-width:70%; 
                    padding:8px 12px;    
                    border-radius:16px;      
                    word-wrap:break-word;    
                    position:relative;
                    {{ $message->user_id === auth()->id() 
                        ? 'background:#e7d7e2ff; color:black; border-bottom-right-radius:4px;' 
                        : 'background:#dddcedff; color:black; border-bottom-left-radius:4px;' }} "
                    class="message-bubble">

                    <!-- Texto del mensaje -->
                    @if($message->body)
                        <span>{{ $message->body }}</span>
                    @endif

                    <!-- Archivo adjunto -->
                    @if($message->file_path)
                        @php $ext = strtolower(pathinfo($message->file_path, PATHINFO_EXTENSION)); @endphp
                        <div style="margin-top:6px;">
                            @if(in_array($ext, ['jpg','jpeg','png','gif']))
                                <img src="{{ Storage::disk('ccs')->url($message->file_path) }}" style="max-width:180px; border-radius:10px;">
                            @elseif(in_array($ext, ['mp4','webm','ogg']))
                                <video controls style="max-width:200px; border-radius:10px;">
                                    <source src="{{ Storage::disk('ccs')->url($message->file_path) }}" type="video/{{ $ext }}">
                                </video>
                            @else
                                <a href="{{ Storage::disk('ccs')->url($message->file_path) }}" target="_blank" style="color:inherit; text-decoration:underline;">📎 Ver archivo</a>
                            @endif
                        </div>
                    @endif

                    <!-- Botón eliminar SOLO si es mío -->
                    @if($message->user_id === auth()->id())
                        <button onclick="if(confirm('¿Seguro que quieres eliminar este mensaje?')) { @this.deleteMessage({{ $message->id }}) }"
                                class="delete-btn">
                            ✖
                        </button>
                    @endif
                </div>

                <!-- Fecha del mensaje -->
                <div style="font-size:0.75rem; color:#555; margin-top:2px;">
                    {{ $message->created_at->format('d/m/Y H:i') }}
                </div>
            </div>
        @endforeach
    </div>

    <!-- Formulario para enviar mensaje -->
    <form wire:submit.prevent="sendMessage" style="display:flex; gap:5px; align-items:center;">
        <input type="text" wire:model="newMessage" placeholder="Escribe tu mensaje..." 
               style="flex:1; padding:8px; border-radius:4px; border:1px solid #bbb8dbff;">

        <!-- Botón "+" para adjuntar archivo -->
        <label style="cursor:pointer; background:#e7bce0ff; padding:8px 12px; border-radius:50%; font-size:18px;">
            +
            <input type="file" wire:model="file" style="display:none;">
        </label>

        <button type="submit" style="padding:8px 12px; border:none; background:#d2cef3ff; color:black; border-radius:4px;">
            Enviar  
        </button>    
    </form>

    @error('newMessage') <span style="color:red;">{{ $message }}</span> @enderror
    @error('file') <span style="color:red;">{{ $message }}</span> @enderror

    <!-- Estilos para hover en botón eliminar -->
    <style>
        .message-bubble {
            position: relative;
        }

        .delete-btn {
            display: none;
            position: absolute;
            top: 4px;
            right: 6px;
            background: none;
            border: none;
            color: #fff;
            cursor: pointer;
            font-size: 14px;
            transition: opacity 0.2s ease-in-out;
            opacity: 0;
        }

        .message-bubble:hover .delete-btn {
            display: block;
            opacity: 1;
        }
    </style>

    <!-- Script para mantener el scroll arriba -->
    <script>
        document.addEventListener('livewire:load', function () {
            const messagesContainer = document.getElementById('messagesContainer');
            function scrollToTop() { messagesContainer.scrollTop = 0; }
            scrollToTop();
            Livewire.hook('message.processed', (message, component) => { scrollToTop(); });
        });
    </script>
</div>
