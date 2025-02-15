<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class AddEntity extends Component
{
    public $entityName;
    public $entityModel;
    public $entityField;
    public $entityValue;

    protected $rules = [
        'entityValue' => 'required|string|max:255',
    ];

    public function createEntity()
    {
        $this->validate();

        $model = app($this->entityModel);
        $model::create([$this->entityField => $this->entityValue]);

        $this->reset('entityValue');
        
        session()->flash('message', ucfirst($this->entityName) . ' criada com sucesso!');
        
        $this->dispatch('entityCreated');
    }

    public function render()
    {
        return view('livewire.add-entity');
    }
}