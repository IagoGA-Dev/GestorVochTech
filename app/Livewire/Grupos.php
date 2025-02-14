<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\GrupoEconomico;

class Grupos extends Component
{
    protected $listeners = ['grupoCreated' => '$refresh'];

    public function render()
    {
        return view('livewire.grupos', [
            'grupos' => GrupoEconomico::all()
        ]);
    }
}
