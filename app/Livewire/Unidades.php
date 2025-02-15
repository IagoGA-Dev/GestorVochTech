<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Unidade;
use Illuminate\Support\Facades\DB;

class Unidades extends Component
{
    public $selectedUnidades = [];
    public $editingUnidadeId = null;
    public $editingUnidadeNome = '';
    
    protected $listeners = ['unidadeCreated' => '$refresh'];

    protected $rules = [
        'editingUnidadeNome' => 'required|string|max:255',
    ];

    public function getIsDisabledProperty()
    {
        return count($this->selectedUnidades) === 0;
    }

    public function getSelectedCountProperty()
    {
        return count($this->selectedUnidades);
    }

    public function startEdit($unidadeId)
    {
        $unidade = Unidade::find($unidadeId);
        $this->editingUnidadeId = $unidadeId;
        $this->editingUnidadeNome = $unidade->nome_fantasia;
    }

    public function saveEdit()
    {
        $this->validate();

        $unidade = Unidade::find($this->editingUnidadeId);
        $unidade->update(['nome_fantasia' => $this->editingUnidadeNome]);

        $this->editingUnidadeId = null;
        $this->editingUnidadeNome = '';
        
        session()->flash('message', 'Unidade atualizada com sucesso!');
    }

    public function cancelEdit()
    {
        $this->editingUnidadeId = null;
        $this->editingUnidadeNome = '';
    }

    public function deleteUnidade($unidadeId)
    {
        $unidade = Unidade::with(['colaboradores'])->find($unidadeId);
        $colaboradoresNomes = $unidade->colaboradores->pluck('nome')->toArray();
        
        if (count($colaboradoresNomes) > 0) {
            $mensagem = "Os seguintes colaboradores serão removidos:\n";
            foreach ($colaboradoresNomes as $nome) {
                $mensagem .= "- " . $nome . "\n";
            }
            $mensagem .= "\nTem certeza que deseja excluir esta unidade?";
            
            if (!$this->js("confirm(" . json_encode($mensagem) . ")")) {
                return;
            }
        }

        DB::beginTransaction();
        try {
            // Remover primeiro os colaboradores
            foreach ($unidade->colaboradores as $colaborador) {
                $colaborador->delete();
            }
            
            // Por fim, remover a unidade
            $unidade->delete();
            
            DB::commit();
            $this->dispatch('unidadeCreated');
            session()->flash('message', 'Unidade e seus colaboradores foram excluídos com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao excluir a unidade: ' . $e->getMessage());
        }
    }

    public function deleteSelected()
    {
        if ($this->isDisabled) {
            return;
        }

        $unidades = Unidade::with(['colaboradores'])->whereIn('id', $this->selectedUnidades)->get();
        $mensagem = "Os seguintes colaboradores serão removidos:\n\n";
        $temColaboradores = false;

        foreach ($unidades as $unidade) {
            if ($unidade->colaboradores->count() > 0) {
                $temColaboradores = true;
                $mensagem .= "Unidade {$unidade->nome_fantasia}:\n";
                foreach ($unidade->colaboradores as $colaborador) {
                    $mensagem .= "- {$colaborador->nome}\n";
                }
                $mensagem .= "\n";
            }
        }

        if ($temColaboradores) {
            $mensagem .= "Tem certeza que deseja excluir " . (count($this->selectedUnidades) > 1 ? "estas unidades" : "esta unidade") . "?";
            $confirmou = $this->js("confirm(" . json_encode($mensagem) . ")");
            if (!$confirmou) {
                return;
            }
        }

        DB::beginTransaction();
        try {
            foreach ($unidades as $unidade) {
                // Remover primeiro os colaboradores
                foreach ($unidade->colaboradores as $colaborador) {
                    $colaborador->delete();
                }
                
                // Por fim, remover a unidade
                $unidade->delete();
            }
            
            DB::commit();
            $this->selectedUnidades = [];
            session()->flash('message', 'Unidades e seus colaboradores foram excluídos com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao excluir as unidades: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.unidades', [
            'unidades' => Unidade::all(),
        ]);
    }
}