<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

#[\Livewire\Attributes\Layout('layouts.navigation')]
class Chat extends Component
{
    use WithFileUploads;

    public $chatMessages;
    public $newMessage = '';
    public $receiverId;
    public $file;

    public function mount($receiverId)
    {
        $this->receiverId = $receiverId;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->chatMessages = Message::with('user')
            ->where(function ($q) {
                $q->where('user_id', Auth::id())
                  ->where('receiver_id', $this->receiverId);
            })
            ->orWhere(function ($q) {
                $q->where('user_id', $this->receiverId)
                  ->where('receiver_id', Auth::id());
            })
            ->latest()
            ->take(50)
            ->get();
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'nullable|string|max:1000',
            'file' => 'nullable|file|max:10240', // máximo 10MB
        ]);

        $filePath = null;

        if ($this->file) {
            // Guardar públicamente en Cellar
            $filePath = $this->file->storePublicly('chat_files', 'ccs');
        }

        $message = Message::create([
            'user_id' => Auth::id(),
            'receiver_id' => $this->receiverId,
            'body' => $this->newMessage ?: null,
            'file_path' => $filePath,
        ]);

        // Añadir al inicio del listado
        $this->chatMessages->prepend($message->load('user'));

        // Limpiar inputs
        $this->newMessage = '';
        $this->file = null;
    }

    public function deleteMessage($id)
    {
        $message = Message::find($id);

        if ($message && $message->user_id === Auth::id()) {
            if ($message->file_path && \Storage::disk('ccs')->exists($message->file_path)) {
                \Storage::disk('ccs')->delete($message->file_path);
            }
            $message->delete();
            $this->loadMessages();
        }
    }

    public function render()
    {
        return view('livewire.chat');
    }
}
