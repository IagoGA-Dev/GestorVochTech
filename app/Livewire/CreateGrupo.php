<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\GrupoEconomico;

class CreateGrupo extends Component
{
    public $nome;

    protected $rules = [
        'nome' => 'required|string|max:255',
    ];

    public function createGrupo()
    {
        try {
            $this->validate();

            GrupoEconomico::create(['nome' => $this->nome]);

            $this->reset('nome');
            
            session()->flash('message', 'Grupo criado com sucesso!');
            
            // Disparando o evento para fechar o modal
            $this->js("closeModal()");
            $this->dispatch('grupoCreated');

        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao criar o grupo.');
        }
    }

    public function render()
    {
        return view('livewire.create-grupo');
    }
}
