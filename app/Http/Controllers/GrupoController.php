<?php

namespace App\Http\Controllers;

use App\Models\GrupoEconomico;
use Illuminate\Http\Request;

class GrupoController extends Controller
{
    public function index()
    {
        $grupos = GrupoEconomico::all();
        return view('grupos', compact('grupos'));
    }
}