<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;

Route::get('/', [AccueilController::class, 'index'])->name('route_accueil');
Route::get('/accueil', [AccueilController::class, 'index'])->name('route_accueil');