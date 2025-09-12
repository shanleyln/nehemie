<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Accueil;
use App\Livewire\QuiSommesNous;
use App\Livewire\NosProgrammes;
use App\Livewire\NosActionsEtProjets;
use App\Livewire\Actualites;
use App\Livewire\DonnezLeurVousMemes;
use App\Http\Controllers\PriereController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\PrayerRequestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

// Routes principales
Route::get('/accueil', Accueil::class)->name('route_accueil');
Route::get('/qui-sommes-nous', QuiSommesNous::class)->name('route_qui_sommes_nous');
Route::get('/nos-programmes', NosProgrammes::class)->name('route_nos_programmes');
Route::get('/nos-actions-et-projets', NosActionsEtProjets::class)->name('route_nos_actions_et_projets');
Route::get('/actualites', Actualites::class)->name('route_actualites');

Route::get('/donnez-leur-vous-memes-a-manger', DonnezLeurVousMemes::class)->name('route_donnez_leur_vous_memes');
// Ces routes seront implémentées plus tard
Route::get('/politique-de-confidentialite', function () {
    return redirect()->route('route_accueil');
})->name('route_politique_de_confidentialite');

Route::get('/conditions-dutilisation', function () {
    return redirect()->route('route_accueil');
})->name('route_conditions_dutilisation');


//routes de paiement
Route::get('/Paiement', function () {
    return view('index');
})->name('index');
Route::get('/paiement/success', function (Request $request) {
    return "Paiement simulé réussi pour ref : " . $request->ref;
})->name('paiement.local_success');

Route::get('/paiement/echec', function (Request $request) {
    return "Paiement simulé échoué pour ref : " . $request->ref;
})->name('paiement.local_error');

Route::post('/paiement', [PaiementController::class, 'valider'])->name('paiement.valider');
Route::get('/confirmer/{token}', [PaiementController::class, 'confirmer'])->name('paiement.confirmer');

Route::get('/paiement/finaliser/{ref}', [PaiementController::class, 'finaliser'])->name('paiement.confirme.finaliser');
Route::get('/paiement/echouer/{ref}', [PaiementController::class, 'echouer'])->name('paiement.echouer');



// Cette route affiche le formulaire quand on va sur l'URL /demande-de-priere
Route::get('/demande-de-priere', [PrayerRequestController::class, 'create'])->name('prayer.create');

// Cette route traite les données quand le formulaire est envoyé
Route::post('/demande-de-priere', [PrayerRequestController::class, 'store'])->name('prayer.store');



Route::post('/api/pvit/receive-secret', [PvitController::class, 'receiveSecret']); // appel MyPVit externe => pas de CSRF
