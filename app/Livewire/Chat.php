<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Events\MessageSent;
use App\Notifications\NuevaActividadNotification;

#[\Livewire\Attributes\Layout('layouts.navigation')]
class Chat extends Component
{
    use WithFileUploads;

    public $chatMessages;
    public $newMessage = '';
    public $receiverId;
    public $file;

    protected $listeners = ['incomingMessage' => 'addIncomingMessage'];

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
            try {
                $filePath = $this->file->store('chat_files', 'ccs');
            } catch (\Exception $e) {
                session()->flash('error', 'No se pudo subir el archivo: ' . $e->getMessage());
                return;
            }
        }

        $message = Message::create([
            'user_id' => Auth::id(),
            'receiver_id' => $this->receiverId,
            'body' => $this->newMessage ?: null,
            'file_path' => $filePath,
        ]);

        // 🔔 Notificación al receptor (igual que en ReaccionController)
        $sender = Auth::user();
        $receiver = User::find($this->receiverId);

        if ($receiver && $receiver->id !== $sender->id) {
            $preview = $this->newMessage
                ? (strlen($this->newMessage) > 30
                    ? substr($this->newMessage, 0, 30) . '...'
                    : $this->newMessage)
                : '📎 Archivo enviado';

            $receiver->notify(
                new NuevaActividadNotification(
                    'mensaje',
                    'te envió un mensaje: "' . $preview . '"',
                    $sender
                )
            );
        }

        // 🚀 Emitir evento en tiempo real
        event(new MessageSent($message));

        // Mostrar mensaje inmediatamente
        $this->chatMessages->prepend($message->load('user'));

        $this->reset(['newMessage', 'file']);
    }

    public function addIncomingMessage($event)
    {
        // Evitar duplicar si el mensaje es del usuario actual
        if ($event['user_id'] == Auth::id()) {
            return;
        }

        $this->chatMessages->prepend((object)[
            'id' => $event['id'],
            'body' => $event['body'],
            'file_path' => $event['file_path'],
            'user_id' => $event['user_id'],
            'user' => (object)['name' => $event['user_name']],
            'created_at' => now(),
        ]);
    }

    public function deleteMessage($id)
    {
        $message = Message::find($id);

        if ($message && $message->user_id === Auth::id()) {
            if ($message->file_path && Storage::disk('ccs')->exists($message->file_path)) {
                Storage::disk('ccs')->delete($message->file_path);
            }
            $message->delete();
            $this->loadMessages();
        }
    }

    public function render()
    {
        return view('livewire.chat', [
            'chatMessages' => $this->chatMessages,
        ]);
    }
}
