<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccueilController;

Route::get('/accueil', [AccueilController::class, 'index'])->name('route_accueil');
