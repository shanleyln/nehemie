<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class NosActionsEtProjetsController extends Controller
{
    /**
     * Affiche la page "Nos actions et projets"
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('nos_actions_et_projets');
    }
}