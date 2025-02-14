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

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        GrupoEconomico::create(['nome' => $request->nome]);

        return redirect()->route('grupos.index')->with('success', 'Grupo criado com sucesso!');
    }
}