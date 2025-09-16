<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PvitController;

// Webhook PVit: on force la présence du code (ex: /api/pvit/receive-secret/GH8CQ)
Route::post('/pvit/receive-secret/{code}', [PvitController::class, 'receiveSecret'])
    ->whereAlphaNumeric('code')   // Laravel 12: contraint "code" à [A-Za-z0-9]
    ->name('pvit.receiveSecret.withCode');