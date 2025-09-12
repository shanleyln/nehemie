<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;

class AppLayout extends Component
{
    public $currentRoute;

    protected $listeners = ['navigate' => 'updateRoute'];

    public function mount()
    {
        $this->currentRoute = request()->route()->getName();
    }

    public function updateRoute($routeName)
    {
        $this->currentRoute = $routeName;
        $this->emit('routeUpdated', $routeName);
    }

    public function isActive($routeName)
    {
        return $this->currentRoute === $routeName;
    }

    public function render()
    {
        return view('livewire.app-layout');
    }
}
