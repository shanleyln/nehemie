<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class NosActionsEtProjets extends Component
{
    public array $events = [];

    public function mount()
    {
        $this->loadEvents();
    }

    protected function loadEvents()
    {
        // Les données statiques de vos actions et projets
        $this->events = [
            [
                'id' => 4,
                'title' => "Rapport d'Activités 2024",
                'date' => "2024-12-18",
                'description' => "Rapport annuel présentant les réalisations et la vision de l'ONG Néhémie International pour l'année 2024. Ce document inclut le mot du président, une présentation détaillée de l'ONG, ses missions, et un bilan des actions menées.",
                'documents' => [
                    [
                        'title' => "Rapport d'Activités ONG NÉHÉMIE 2024",
                        'url' => asset('pdf/Rapport_Activites_Nehemie_2024.pdf'),
                        'type' => "PDF",
                        'size' => "N/A"
                    ]
                ],
                'videos' => [],
                'images' => []
            ],
            [
                'id' => 1,
                'title' => "Campagne de Construction pour la Veuve Mboumba",
                'date' => "2024-07-15",
                'description' => "Un projet visant à construire une maison décente pour la veuve Mboumba et sa famille, mobilisant des bénévoles et des donateurs pour fournir un abri sûr.",
                'documents' => [],
                'videos' => [
                    [
                        'youtubeId' => "83OM-xm7MWM",
                        'title' => "La minute du Bâtisseur"
                    ],
                    [
                        'youtubeId' => "II4s03zenqk",
                        'title' => "Appel à l'action"
                    ]
                ],
                'images' => [
                    [
                        'src' => asset('images/actions_projets/act1.jpg'),
                        'alt' => "Chantier"
                    ],
                    [
                        'src' => asset('images/actions_projets/act4.jpg'),
                        'alt' => "Bénévoles"
                    ]
                ]
            ],
            [
                'id' => 2,
                'title' => "Consécration de l'Année 2025",
                'date' => "2024-05-10",
                'description' => "Rassemblement pour célébrer les réussites et consacrer l'année à venir.",
                'documents' => [],
                'videos' => [
                    [
                        'youtubeId' => "LQ-IQJfyYKg",
                        'title' => "Consécration 2025"
                    ]
                ],
                'images' => [
                    [
                        'src' => asset('images/actions_projets/act3.jpg'),
                        'alt' => "Rassemblement"
                    ]
                ]
            ]
        ];
    }

    public function render()
    {
        return view('livewire.nos-actions-et-projets');
    }
}
