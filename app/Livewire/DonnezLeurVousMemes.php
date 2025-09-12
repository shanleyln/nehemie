<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class DonnezLeurVousMemes extends Component
{
    public function render()
    {
        return view('livewire.donnez-leur-vous-memes');
    }
}
