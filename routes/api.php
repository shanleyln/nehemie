<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PvitController; // Assurez-vous d'importer votre contrôleur

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


// === VOTRE ROUTE ===
// Ajoutez ce bloc de code
Route::post('/pvit/receive-secret', [PvitController::class, 'receiveSecret'])->name('pvit.receiveSecret.api');