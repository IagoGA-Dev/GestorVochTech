<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\GrupoEconomico;
use Illuminate\Support\Facades\DB;

class Grupos extends Component
{
    public $selectedGroups = [];
    public $editingGrupoId = null;
    public $editingGrupoNome = '';
    
    protected $listeners = ['grupoCreated' => '$refresh'];

    protected $rules = [
        'editingGrupoNome' => 'required|string|max:255',
    ];

    public function getIsDisabledProperty()
    {
        return count($this->selectedGroups) === 0;
    }

    public function getSelectedCountProperty()
    {
        return count($this->selectedGroups);
    }

    public function startEdit($grupoId)
    {
        $grupo = GrupoEconomico::find($grupoId);
        $this->editingGrupoId = $grupoId;
        $this->editingGrupoNome = $grupo->nome;
    }

    public function saveEdit()
    {
        $this->validate();

        $grupo = GrupoEconomico::find($this->editingGrupoId);
        $grupo->update(['nome' => $this->editingGrupoNome]);

        $this->editingGrupoId = null;
        $this->editingGrupoNome = '';
        
        session()->flash('message', 'Grupo atualizado com sucesso!');
    }

    public function cancelEdit()
    {
        $this->editingGrupoId = null;
        $this->editingGrupoNome = '';
    }

    public function deleteGrupo($grupoId)
    {
        $grupo = GrupoEconomico::with(['bandeiras.unidades'])->find($grupoId);
        $bandeirasNomes = $grupo->bandeiras->pluck('nome')->toArray();
        
        if (count($bandeirasNomes) > 0) {
            $mensagem = "As seguintes bandeiras serão removidas:\n";
            foreach ($bandeirasNomes as $nome) {
                $mensagem .= "- " . $nome . "\n";
            }
            $mensagem .= "\nTem certeza que deseja excluir este grupo?";
            
            if (!$this->js("confirm(" . json_encode($mensagem) . ")")) {
                return;
            }
        }

        DB::beginTransaction();
        try {
            // Remover primeiro as unidades de cada bandeira
            foreach ($grupo->bandeiras as $bandeira) {
                foreach ($bandeira->unidades as $unidade) {
                    // Remover relacionamentos da unidade primeiro
                    $unidade->colaboradores()->delete();
                    $unidade->delete();
                }
            }
            
            // Depois remover as bandeiras
            foreach ($grupo->bandeiras as $bandeira) {
                $bandeira->delete();
            }
            
            // Por fim, remover o grupo
            $grupo->delete();
            
            DB::commit();
            $this->dispatch('grupoCreated');
            session()->flash('message', 'Grupo e suas bandeiras foram excluídos com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao excluir o grupo: ' . $e->getMessage());
        }
    }

    public function deleteSelected()
    {
        if ($this->isDisabled) {
            return;
        }

        $grupos = GrupoEconomico::with(['bandeiras.unidades'])->whereIn('id', $this->selectedGroups)->get();
        $mensagem = "As seguintes bandeiras serão removidas:\n\n";
        $temBandeiras = false;

        foreach ($grupos as $grupo) {
            if ($grupo->bandeiras->count() > 0) {
                $temBandeiras = true;
                $mensagem .= "Grupo {$grupo->nome}:\n";
                foreach ($grupo->bandeiras as $bandeira) {
                    $mensagem .= "- {$bandeira->nome}\n";
                }
                $mensagem .= "\n";
            }
        }

        if ($temBandeiras) {
            $mensagem .= "Tem certeza que deseja excluir " . (count($this->selectedGroups) > 1 ? "estes grupos" : "este grupo") . "?";
            $confirmou = $this->js("confirm(" . json_encode($mensagem) . ")");
            if (!$confirmou) {
                return;
            }
        }

        DB::beginTransaction();
        try {
            foreach ($grupos as $grupo) {
                // Remover primeiro as unidades de cada bandeira
                foreach ($grupo->bandeiras as $bandeira) {
                    foreach ($bandeira->unidades as $unidade) {
                        // Remover relacionamentos da unidade primeiro
                        $unidade->colaboradores()->delete();
                        $unidade->delete();
                    }
                }
                
                // Depois remover as bandeiras
                foreach ($grupo->bandeiras as $bandeira) {
                    $bandeira->delete();
                }
                
                // Por fim, remover o grupo
                $grupo->delete();
            }
            
            DB::commit();
            $this->selectedGroups = [];
            session()->flash('message', 'Grupos e suas bandeiras foram excluídos com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao excluir os grupos: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.grupos', [
            'grupos' => GrupoEconomico::all(),
        ]);
    }
}
