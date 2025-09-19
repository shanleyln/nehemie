<?php

// app/Livewire/Nehemie/ChatAssistant.php

namespace App\Livewire\Nehemie;

use Livewire\Component;

class ChatAssistant extends Component
{
    public bool $open = false;
    public string $question = '';

    public function toggle()
    {
        $this->open = !$this->open;
    }
    public function quick(string $q)
    {
        $this->question = $q; /* TODO: traiter */
    }
    public function render()
    {
        return view('livewire.nehemie.chat-assistant');
    }
}