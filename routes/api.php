<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PvitController;

// Réception de clé: URL sans code (ex: .../api/pvit/receive-secret)
Route::post('/pvit/receive-secret', [PvitController::class, 'receiveSecret'])
    ->name('pvit.receiveSecret');

// Rétro-compat: URL avec code (ex: .../api/pvit/receive-secret/GH8CQ)
Route::post('/pvit/receive-secret/{code}', [PvitController::class, 'receiveSecret'])
    ->name('pvit.receiveSecret.withCode');

// (optionnel pour test rapide) affichage HTML du journal même via /api
Route::get('/pvit/secrets-log', [PvitController::class, 'secretsLog'])
    ->name('pvit.secretsLog.api');