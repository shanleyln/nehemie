<?php

// app/Livewire/Nehemie/AppShell.php

namespace App\Livewire\Nehemie;

use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;

class AppShell extends Component
{
    #[Url(as: 'tab')]
    public string $page = 'actualites'; // actualites|don|membre|contact|menu  + 'about','projects','engage'

    public function setPage(string $page): void
    {
        $this->page = $page;
        if ($page === 'membre') {
            // signal pour init le chart quand tableau membre visible
            $this->dispatch('member-page-opened');
        }
    }

    #[On('goto')]
    public function goto(string $page)
    {
        $this->setPage($page);
    }

    public function render()
    {
        return view('livewire.nehemie.app-shell')
        ->layout('layouts.nehemie-mobile');
    }
}