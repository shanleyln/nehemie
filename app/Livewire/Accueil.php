<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout; // Important : importer Layout

#[Layout('layouts.app')] // <-- Ajouter ceci
class Accueil extends Component
{
    public $activeTab = 'salomon';
    
    public function changeTab($tabName)
    {
        $this->activeTab = $tabName;
    }
    
    public function render()
    {
        return view('livewire.accueil');
    }
}
