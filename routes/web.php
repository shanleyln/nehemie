<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Livewire\Accueil;
use App\Livewire\QuiSommesNous;
use App\Livewire\NosProgrammes;
use App\Livewire\NosActionsEtProjets;
use App\Livewire\Actualites;
use App\Livewire\DonnezLeurVousMemes;
use App\Http\Controllers\PriereController;
use App\Http\Controllers\PrayerRequestController;
use App\Http\Controllers\PvitController;
use App\Livewire\Nehemie\AppShell;

//***************************************Site******************************************

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

// Cette route affiche le formulaire quand on va sur l'URL /demande-de-priere
Route::get('/demande-de-priere', [PrayerRequestController::class, 'create'])->name('prayer.create');

// Cette route traite les données quand le formulaire est envoyé
Route::post('/demande-de-priere', [PrayerRequestController::class, 'store'])->name('prayer.store');



//***************************************PVIT******************************************
Route::get('/paiement', [\App\Http\Controllers\PvitController::class, 'publicPayForm'])
    ->name('pvit.public.pay');

Route::prefix('pvit')->group(function () {

    // Écran unique (formulaires REST/LINK/STATUS/BALANCE)
    Route::get('/transactions', [PvitController::class, 'transactionsForm'])->name('pvit.transactions');

    Route::prefix('pvit')->group(function () {
        Route::post('/kyc', [\App\Http\Controllers\PvitController::class, 'kycCheck'])->name('pvit.kyc.check');
        // (le reste inchangé : transactions, status, balance, settings…)
    });


    // Actions
    Route::post('/link', [PvitController::class, 'linkInit'])->name('pvit.link.init');
    Route::post('/status', [PvitController::class, 'statusCheck'])->name('pvit.status.check');
    Route::post('/balance', [PvitController::class, 'balanceCheck'])->name('pvit.balance.check');

    // UI paramètres
    Route::get('/settings', [PvitController::class, 'settingsForm'])->name('pvit.settings');
    Route::post('/settings', [PvitController::class, 'settingsSave'])->name('pvit.settings.save');

    // Action admin (POST depuis ta page) — garde en "web" (CSRF OK)
    Route::post('/renew-secret', [PvitController::class, 'renewSecret'])->name('pvit.renewSecret');

    // Journal HTML des clés reçues (vue)
    Route::get('/secrets-log', [PvitController::class, 'secretsLog'])->name('pvit.secretsLog');
});


// Route pour le téléchargement des factures
Route::get('/facture/{reference}', [\App\Http\Controllers\InvoiceController::class, 'generate'])
    ->name('invoice.download');

// Routes de paiement
Route::get('/paiement/succes', function (Request $request) {
    $reference = $request->query('reference');

    if (empty($reference)) {
        // If no reference is provided, redirect back with an error
        return redirect()->route('pvit.public.pay')->with('error', 'Référence de paiement manquante');
    }

    return view('pvit.payment_success', [
        'reference' => $request->query('reference')
    ]);
})->name('payment.success');

Route::get('/paiement/echec', function (Request $request) {
    return view('pvit.payment_failed', [
        'reference' => $request->query('reference'),
        'message' => $request->query('message', 'Une erreur inconnue est survenue.')
    ]);
})->name('payment.failed');



//***************************************Mobile******************************************
Route::get('/nehemie', AppShell::class)->name('nehemie.app');
