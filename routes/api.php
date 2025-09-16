<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PvitController;

// Webhook PVit — sans CSRF
Route::post('/pvit/receive-secret', [PvitController::class, 'receiveSecret'])
    ->name('pvit.receiveSecret');
// Variante rétro-compatible avec un code dans l’URL
Route::post('/pvit/receive-secret/{code}', [PvitController::class, 'receiveSecret'])
    ->name('pvit.receiveSecret.withCode');