<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.app')]
class Actualites extends Component
{
    public $featured;
    public $publications = [];
    public $error = null;
    public $isLoading = true;
    
    // Propriétés pour la modale
    public $showModal = false;
    public $modalTitle = '';
    public $modalContent = '';
    public $modalImage = '';
    public $modalDate = '';
    public $modalAuthor = '';

    public function mount()
    {
        $this->loadActualites();
    }

    public function loadActualites()
    {
        $this->isLoading = true;
        $this->error = null;
        $this->featured = null;
        $this->publications = [];

        try {
            $apiUrl = 'https://api3.yodingenierie.com/api_nehemie/liste_publication';
            $apiKey = 'AOoEQWP9T5L1CAmeQxFbn8oxiC2ES9EB';

            Log::info('Tentative de chargement des actualités depuis: ' . $apiUrl);

            $response = Http::withHeaders([
                'X-API-KEY' => $apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->timeout(30)->get($apiUrl);

            if (!$response->successful()) {
                throw new \Exception('Erreur API: ' . $response->status() . ' - ' . $response->body());
            }

            $responseData = $response->json();
            Log::debug('Réponse API brute:', $responseData);
            
            // Vérifier si la réponse contient le tableau des publications
            if (!isset($responseData['publications']) || !is_array($responseData['publications'])) {
                throw new \Exception('Format de réponse API invalide. Le tableau des publications est manquant.');
            }
            
            $publicationsData = $responseData['publications'];

            $publications = collect($publicationsData)
                ->filter(function ($item) {
                    // Vérifier que c'est un tableau avec les champs requis
                    if (!is_array($item)) {
                        Log::debug('Élément ignoré - Pas un tableau', ['item' => $item]);
                        return false;
                    }

                    $hasRequiredFields = isset($item['date_publication']) && is_string($item['date_publication']);
                    if (!$hasRequiredFields) {
                        Log::debug('Élément ignoré - Champs requis manquants', ['item' => $item]);
                    }

                    return $hasRequiredFields;
                })
                ->map(function ($publication) {
                    try {
                        // Nettoyer et formater les données
                        $dateStr = trim($publication['date_publication']);
                        $date = \Carbon\Carbon::parse($dateStr);

                        $formattedPublication = [
                            'id' => $publication['id'] ?? null,
                            'idassociation' => $publication['idassociation'] ?? null,
                            'username' => $publication['username'] ?? null,
                            'texte_publication' => nl2br(e($publication['texte_publication'] ?? '')),
                            'date_publication' => $dateStr,
                            'date_formatted' => $date->locale('fr_FR')->isoFormat('LL'),
                            'date_object' => $date,
                            'fichier_cover' => $publication['fichier_cover'] ?? null,
                            'type_fichier' => $publication['type_fichier'] ?? null
                        ];

                        Log::debug('Publication formatée', $formattedPublication);
                        return $formattedPublication;

                    } catch (\Exception $e) {
                        Log::warning('Erreur lors du formatage d\'une publication', [
                            'error' => $e->getMessage(),
                            'publication' => $publication
                        ]);
                        return null;
                    }
                })
                ->filter() // Enlève les entrées null
                ->sortByDesc('date_object')
                ->values();

            Log::info('Nombre de publications valides trouvées: ' . $publications->count());

            if ($publications->isNotEmpty()) {
                $this->featured = $publications->shift();
                $this->publications = $publications->all();
                Log::info('Actualités chargées avec succès', [
                    'featured_id' => $this->featured['id'] ?? null,
                    'publications_count' => count($this->publications)
                ]);
            } else {
                $this->error = 'Aucune actualité valide trouvée dans la réponse.';
                Log::warning('Aucune actualité valide trouvée dans la réponse API');
            }

        } catch (\Exception $e) {
            Log::error('Erreur lors du chargement des actualités: ' . $e->getMessage());
            $this->error = 'Une erreur est survenue lors du chargement des actualités. Veuillez réessayer plus tard.';
        } finally {
            $this->isLoading = false;
        }
    }

    protected function handleApiError($response)
    {
        $statusCode = $response->status();
        $errorBody = $response->body();

        Log::error("Erreur API Actualités - Status: $statusCode - Réponse: $errorBody");

        $this->error = 'Échec de récupération des actualités. ';
        if ($statusCode === 401) {
            $this->error .= 'Erreur d\'authentification API.';
        } elseif ($statusCode >= 500) {
            $this->error .= 'Le serveur distant rencontre des difficultés.';
        } else {
            $this->error .= 'Veuillez réessayer plus tard.';
        }
    }

    public function showFullNews($data)
    {
        $this->modalTitle = $data['title'];
        $this->modalContent = $data['content'];
        $this->modalImage = $data['image'] ?? '';
        $this->modalDate = $data['date'] ?? '';
        $this->modalAuthor = $data['author'] ?? '';
        $this->showModal = true;
    }
    
    public function closeModal()
    {
        $this->showModal = false;
    }
    
    public function render()
    {
        return view('livewire.actualites');
    }
}
