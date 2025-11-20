<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuiaRapidaController extends Controller
{
    public function index()
    {
        return view('guias-rapidas.index');
    }

    public function dueno()
    {
        return view('guias-rapidas.dueno');
    }

    public function veterinaria()
    {
        return view('guias-rapidas.veterinaria');
    }

    public function refugio()
    {
        return view('guias-rapidas.refugio');
    }
}