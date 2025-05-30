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
            // Appel API pour récupérer les publications
            $response = Http::withHeaders([
                'X-API-KEY' => 'AOoEQWP9T5L1CAmeQxFbn8oxiC2ES9EB',
                'Content-Type' => 'application/json'
            ])->get('https://api3.yodingenierie.com/api_nehemie/liste_publication');

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
                $errorMessage = 'Échec de récupération des actualités. Veuillez réessayer plus tard.';
                return view('actualites', ['error' => $errorMessage]);
            }
        } catch (\Exception $e) {
            // En cas d'exception inattendue
            $errorMessage = 'Une erreur est survenue lors du chargement des actualités. Veuillez réessayer plus tard.';
            return view('actualites', ['error' => $errorMessage]);
        }
    }
}