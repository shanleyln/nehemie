<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class NosProgrammes extends Component
{
    public $activeTab = 'salomon';
    
    public function changeTab($tabName)
    {
        $this->activeTab = $tabName;
    }
    
    public function render()
    {
        return view('livewire.nos-programmes');
    }
}
