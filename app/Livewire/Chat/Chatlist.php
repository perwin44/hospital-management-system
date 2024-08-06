<?php

namespace App\Livewire\Chat;

use App\Models\Conversation;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Chatlist extends Component
{

    public $conversations;
    public $auth_email;
    public $receviverUser;
    public $selected_conversation;
    protected $listeners = ['chatUserSelected', 'refresh' => '$refresh'];

    public function mount()
    {
        $this->auth_email = auth()->user()->email;
    }

    public function getUsers(Conversation $conversation, $request)
    {

        if ($conversation->sender_email == $this->auth_email) {
            $this->receviverUser = Doctor::firstwhere('email', $conversation->receiver_email);
        } else {
            $this->receviverUser = Patient::firstwhere('email', $conversation->sender_email);
        }
        if (isset($request)) {
            return $this->receviverUser->$request;
        }
    }


    public function chatUserSelected(Conversation $conversation, $receiver_id)
    {

        $this->selected_conversation = $conversation;
        $this->receviverUser = Doctor::find($receiver_id);
        if (Auth::guard('patient')->check()) {
            $this->dispatch('load_conversationDoctor', $this->selected_conversation, $this->receviverUser)->to('chat.chatbox');
            $this->dispatch('updateMessage', $this->selected_conversation, $this->receviverUser)->to('chat.send-message');
        } else {
            $this->dispatch('load_conversationPatient', $this->selected_conversation, $this->receviverUser)->to('chat.chatbox');
            $this->dispatch('updateMessage2', $this->selected_conversation, $this->receviverUser)->to('chat.send-message');
        }

    }


    public function render()
    {
        $this->conversations = Conversation::where('sender_email', $this->auth_email)->orwhere('receiver_email', $this->auth_email)
            ->orderBy('created_at', 'DESC')
            ->get();
        return view('livewire.chat.chatlist');
    }
}
