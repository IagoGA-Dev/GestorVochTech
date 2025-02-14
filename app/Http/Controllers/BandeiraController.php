<?php

namespace App\Http\Controllers;

use App\Models\Bandeira;
use Illuminate\Http\Request;

class BandeiraController extends Controller
{
    public function index()
    {
        $bandeiras = Bandeira::all();
        return view('bandeiras', compact('bandeiras'));
    }
}