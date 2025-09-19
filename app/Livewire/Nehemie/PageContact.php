<?php

// app/Livewire/Nehemie/PageContact.php

namespace App\Livewire\Nehemie;

use Livewire\Component;

class PageContact extends Component
{
    public string $name = '';
    public string $email = '';
    public string $subject = 'Question générale';
    public string $message = '';

    public function send()
    { /* TODO: mail/DB */ $this->reset(['name','email','message']);
        $this->dispatch('toast', 'Message envoyé');
    }
    public function render()
    {
        return view('livewire.nehemie.page-contact');
    }
}