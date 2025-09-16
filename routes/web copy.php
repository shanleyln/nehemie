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
use App\Http\Controllers\PvitController;
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


// Routes de paiement PVit
Route::get('/paiement', function () {
    return view('index');
})->name('paiement.form');

// Routes pour le suivi du paiement
Route::get('/paiement/succes/{reference}', [PaiementController::class, 'finaliser'])->name('paiement.succes');
Route::get('/paiement/echec/{reference}', [PaiementController::class, 'echouer'])->name('paiement.echec');
Route::get('/paiement/verifier/{reference}', [PaiementController::class, 'verifierStatut'])->name('paiement.verifier');

Route::get('/paiement/finaliser/{ref}', [PaiementController::class, 'finaliser'])->name('paiement.confirme.finaliser');
Route::get('/paiement/echouer/{ref}', [PaiementController::class, 'echouer'])->name('paiement.echouer');



// Cette route affiche le formulaire quand on va sur l'URL /demande-de-priere
Route::get('/demande-de-priere', [PrayerRequestController::class, 'create'])->name('prayer.create');

// Cette route traite les données quand le formulaire est envoyé
Route::post('/demande-de-priere', [PrayerRequestController::class, 'store'])->name('prayer.store');

Route::post('/paiement/initier', [PaiementController::class, 'initierPaiement']);
Route::post('/paiement/callback', [PaiementController::class, 'handleCallback']);

// Page admin (afficher/générer la clé)
Route::get('/admin/pvit/secret', [PvitController::class, 'secretPage'])
    ->name('pvit.secret');

// Bouton "Générer la clé" (POST du form de la page)
Route::post('/admin/pvit/renew-secret', [PvitController::class, 'renewSecretProxy'])
    ->name('pvit.renew');