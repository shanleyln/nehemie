<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonnezLeurVousMemesController extends Controller
{
    /**
     * Affiche la page "Donnez-leur vous-mêmes à manger"
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('donnez_leur_vous_memes');
    }
}