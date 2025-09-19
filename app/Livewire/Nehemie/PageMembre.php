<?php

// app/Livewire/Nehemie/PageMembre.php

namespace App\Livewire\Nehemie;

use Livewire\Attributes\On;
use Livewire\Component;

class PageMembre extends Component
{
    public bool $logged = false;

    #[On('member-page-opened')]
    public function onOpen()
    {
        if ($this->logged) {
            $this->dispatch('init-don-chart', data:[
                15000,25000,20000,35000,30000,45000,25000,40000,35000,75000,50000,25000
            ]);
        }
    }

    public function login()
    {
        $this->logged = true;
        $this->onOpen();
    }
    public function logout()
    {
        $this->logged = false;
    }

    public function render()
    {
        return view('livewire.nehemie.page-membre');
    }
}