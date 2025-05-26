<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;
use App\Http\Controllers\PriereController;
use App\Http\Controllers\QuiSommesNousController;
use App\Http\Controllers\NosProgrammesController;
use App\Http\Controllers\NosActionsEtProjetsController;
use App\Http\Controllers\ActualitesController;
use App\Http\Controllers\DonnezLeurVousMemesController;

// Routes principales

Route::get('/', [AccueilController::class, 'index'])->name('route_accueil');
Route::get('/qui-sommes-nous', [QuiSommesNousController::class, 'index'])->name('route_qui_sommes_nous');
Route::get('/nos-programmes', [NosProgrammesController::class, 'index'])->name('route_nos_programmes');
Route::get('/nos-actions-et-projets', [NosActionsEtProjetsController::class, 'index'])->name('route_nos_actions_et_projets');
Route::get('/actualites', [ActualitesController::class, 'index'])->name('route_actualites');
Route::get('/politique-de-confidentialite', [AccueilController::class, 'politiqueDeConfidentialite'])->name('route_politique_de_confidentialite');
Route::get('/conditions-dutilisation', [AccueilController::class, 'conditionsDutilisation'])->name('route_conditions_dutilisation');
Route::get('/donnez-leur-vous-memes-a-manger', [DonnezLeurVousMemesController::class, 'index'])->name('route_donnez_leur_vous_memes');