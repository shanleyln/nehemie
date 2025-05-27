<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ActualitesController extends Controller
{
    /**
     * Affiche la page "Actualités"
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('actualites');
    }
}