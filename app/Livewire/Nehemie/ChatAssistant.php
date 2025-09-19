<?php

// app/Livewire/Nehemie/ChatAssistant.php

namespace App\Livewire\Nehemie;

use Livewire\Component;
use Livewire\Attributes\Url;

class ChatAssistant extends Component
{
    #[Url(as: 'tab')]
    public string $page = 'chat'; // chat|don|membre|contact|menu

    public function render()
    {
        return view('livewire.nehemie.chat-assistant');
    }
}
