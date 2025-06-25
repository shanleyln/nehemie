<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ActualitesController extends Controller
{
    /**
     * Affiche la page "Actualités" avec la liste des publications
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $apiUrl = 'https://api3.yodingenierie.com/api_nehemie/liste_publication';
            $apiKey = 'AOoEQWP9T5L1CAmeQxFbn8oxiC2ES9EB';

            // Vérifier si cURL est disponible
            if (!extension_loaded('curl')) {
                \Log::error('cURL n\'est pas installé sur le serveur');
                return view('actualites', ['error' => 'Configuration serveur incomplète. Veuillez contacter l\'administrateur.']);
            }

            // Vérifier la configuration SSL
            $sslVerify = config('app.env') === 'production' ? true : false;

            $response = Http::withOptions([
                'verify' => $sslVerify,
                'debug' => config('app.debug') ? fopen('php://stderr', 'w') : false,
            ])->withHeaders([
                'X-API-KEY' => $apiKey,
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ])->timeout(30)
              ->get($apiUrl);

            // Vérifie si l'appel est un succès
            if ($response->successful()) {
                $reponseData = $response->json();

                // Vérifier si la réponse contient bien des publications
                if (isset($reponseData['status']) && $reponseData['status'] === 'success' && isset($reponseData['publications'])) {
                    $publications = collect($reponseData['publications'])->map(function ($publication) {
                        // Formater la date en français
                        $date = \Carbon\Carbon::parse($publication['date_publication']);
                        $publication['date_formatted'] = $date->locale('fr_FR')->isoFormat('LL');
                        $publication['date_object'] = $date;
                        return $publication;
                    })->sortByDesc('date_object');

                    // Récupérer l'actualité la plus récente
                    $featured = $publications->shift();

                    return view('actualites', [
                        'featured' => $featured,
                        'publications' => $publications
                    ]);
                } else {
                    // Retourner la vue avec un message d'erreur à afficher dans la modal
                    $errorMessage = 'Aucune publication trouvée.';
                    return view('actualites', ['error' => $errorMessage]);
                }
            } else {
                // En cas d'erreur de l'API
                $statusCode = $response->status();
                $errorBody = $response->body();

                \Log::error("Erreur API Actualités - Status: $statusCode - Réponse: $errorBody");

                $errorMessage = 'Échec de récupération des actualités. ';
                if ($statusCode === 401) {
                    $errorMessage .= 'Erreur d\'authentification API.';
                } elseif ($statusCode >= 500) {
                    $errorMessage .= 'Le serveur distant rencontre des difficultés.';
                } else {
                    $errorMessage .= 'Veuillez réessayer plus tard.';
                }

                return view('actualites', [
                    'error' => $errorMessage,
                    'debug' => config('app.debug') ? [
                        'status' => $statusCode,
                        'response' => $errorBody
                    ] : null
                ]);
            }
        } catch (\Exception $e) {
            // En cas d'exception inattendue
            $errorMessage = 'Une erreur est survenue lors du chargement des actualités. Veuillez réessayer plus tard.';
            return view('actualites', ['error' => $errorMessage]);
        }
    }
}
