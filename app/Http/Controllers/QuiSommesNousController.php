<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuiSommesNousController extends Controller
{
    /**
     * Affiche la page "Qui sommes-nous"
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('qui_sommes_nous');
    }
}