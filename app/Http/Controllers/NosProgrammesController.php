<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class NosProgrammesController extends Controller
{
    /**
     * Affiche la page "Nos programmes"
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('nos_programmes');
    }
}