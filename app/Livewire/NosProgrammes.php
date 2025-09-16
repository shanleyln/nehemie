<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class NosProgrammes extends Component
{
    public $activeTab = 'salomon';
    
    protected $listeners = ['changeTab' => 'handleTabChange'];
    
    public function mount()
    {
        // Vérifier le paramètre d'URL
        if (request()->has('tab')) {
            $tab = request()->query('tab');
            if (in_array($tab, ['salomon', 'joseph', 'david', 'daniel', 'priscille'])) {
                $this->activeTab = $tab;
            }
        }
        
        // Vérifier l'ancre dans l'URL (pour la compatibilité avec les anciens liens)
        if (request()->hasHeader('referer')) {
            $referer = request()->header('referer');
            if (str_contains($referer, '#')) {
                $fragment = explode('#', $referer)[1];
                $tabFromFragment = str_replace('programme-', '', $fragment);
                if (in_array($tabFromFragment, ['salomon', 'joseph', 'david', 'daniel', 'priscille'])) {
                    $this->activeTab = $tabFromFragment;
                }
            }
        }
    }
    
    public function handleTabChange($tabData)
    {
        if (isset($tabData['tab']) && in_array($tabData['tab'], ['salomon', 'joseph', 'david', 'daniel', 'priscille'])) {
            $this->activeTab = $tabData['tab'];
            $this->dispatch('tabChanged', tab: $this->activeTab);
            
            // Mettre à jour l'URL sans recharger la page
            $this->dispatch('updateUrl', url: route('route_nos_programmes', ['tab' => $this->activeTab]));
        }
    }
    
    public function changeTab($tabName)
    {
        if (in_array($tabName, ['salomon', 'joseph', 'david', 'daniel', 'priscille'])) {
            $this->activeTab = $tabName;
            $this->dispatch('tabChanged', tab: $this->activeTab);
            
            // Mettre à jour l'URL sans recharger la page
            $this->dispatch('updateUrl', url: route('route_nos_programmes', ['tab' => $tabName]));
        }
    }
    
    public function render()
    {
        return view('livewire.nos-programmes');
    }
}
