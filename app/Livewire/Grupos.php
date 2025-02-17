<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\GrupoEconomico;
use Illuminate\Support\Facades\DB;
use App\Traits\WithExport;

class Grupos extends Component
{
    use WithExport;

    public $selectedGroups = [];
    
    protected $listeners = [
        'grupoCreated' => '$refresh',
        'grupoUpdated' => '$refresh'
    ];

    public function getIsDisabledProperty()
    {
        return count($this->selectedGroups) === 0;
    }

    public function getSelectedCountProperty()
    {
        return count($this->selectedGroups);
    }

    public function getExportHeaders(): array
    {
        return [
            'ID',
            'Nome',
            'Criado em',
            'Atualizado em'
        ];
    }

    public function getExportData(): array
    {
        return GrupoEconomico::all()
            ->map(fn ($grupo) => [
                $grupo->id,
                $grupo->nome,
                $grupo->created_at->format('d/m/Y H:i:s'),
                $grupo->updated_at->format('d/m/Y H:i:s')
            ])
            ->toArray();
    }

    public function getExportFilename(): string
    {
        return 'grupos';
    }

    public function deleteGrupo($grupoId)
    {
        DB::beginTransaction();
        try {
            $grupo = GrupoEconomico::with(['bandeiras.unidades.colaboradores'])->find($grupoId);
            
            foreach ($grupo->bandeiras as $bandeira) {
                foreach ($bandeira->unidades as $unidade) {
                    foreach ($unidade->colaboradores as $colaborador) {
                        $colaborador->delete();
                    }
                    $unidade->delete();
                }
                $bandeira->delete();
            }
            
            $grupo->delete();
            
            DB::commit();
            $this->dispatch('grupoCreated');
            session()->flash('message', 'Grupo econômico e seus dados relacionados foram excluídos com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao excluir o grupo econômico: ' . $e->getMessage());
        }
    }

    public function deleteSelected()
    {
        if ($this->isDisabled) {
            return;
        }

        DB::beginTransaction();
        try {
            $grupos = GrupoEconomico::with(['bandeiras.unidades.colaboradores'])
                ->whereIn('id', $this->selectedGroups)
                ->get();

            foreach ($grupos as $grupo) {
                foreach ($grupo->bandeiras as $bandeira) {
                    foreach ($bandeira->unidades as $unidade) {
                        foreach ($unidade->colaboradores as $colaborador) {
                            $colaborador->delete();
                        }
                        $unidade->delete();
                    }
                    $bandeira->delete();
                }
                $grupo->delete();
            }
            
            DB::commit();
            $this->selectedGroups = [];
            session()->flash('message', 'Grupos econômicos e seus dados relacionados foram excluídos com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao excluir os grupos econômicos: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.grupos', [
            'grupos' => GrupoEconomico::all()
        ]);
    }
}
