<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\GrupoEconomico;
use App\Traits\WithExport;
use App\Traits\WithDelete;

class Grupos extends Component
{
    use WithExport, WithDelete;

    public $selectedGroups = [];
    
    protected $listeners = [
        'grupoCreated' => '$refresh',
        'grupoUpdated' => '$refresh',
        'entity-deleted' => '$refresh'
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

    protected function getModel()
    {
        return GrupoEconomico::class;
    }

    public function deleteSelected()
    {
        if ($this->isDisabled) {
            return;
        }

        foreach ($this->selectedGroups as $id) {
            $this->confirmDelete($id);
            $this->delete();
        }
        
        $this->selectedGroups = [];
        session()->flash('message', 'Grupos selecionados foram excluídos com sucesso!');
    }

    public function render()
    {
        return view('livewire.grupos', [
            'grupos' => GrupoEconomico::all()
        ]);
    }
}
