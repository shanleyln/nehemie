<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PvitController;

// Réception de la nouvelle clé (appel PVit) — pas de CSRF sur api.php
Route::post('/pvit/receive-secret/{code}', [PvitController::class, 'receiveSecret'])
    ->name('pvit.receiveSecret');

// (facultatif) un GET pour vérifier vite fait depuis le navigateur
Route::get('/pvit/secrets-log', [PvitController::class, 'secretsLog'])
    ->name('pvit.secretsLog.api');