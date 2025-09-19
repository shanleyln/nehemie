<?php

// app/Livewire/Nehemie/PageDon.php

namespace App\Livewire\Nehemie;

use Livewire\Component;

class PageDon extends Component
{
    public ?int $amount = null;
    public string $program = 'Tous les programmes';
    public string $frequency = 'once';

    public function selectAmount(int $value)
    {
        $this->amount = $value;
    }
    public function confirm()
    { /* TODO: paiement */
    }

    public function render()
    {
        return view('livewire.nehemie.page-don');
    }
}