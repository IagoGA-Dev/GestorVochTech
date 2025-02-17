<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bandeira;
use App\Traits\WithExport;
use App\Traits\WithDelete;

class Bandeiras extends Component
{
    use WithExport, WithDelete;

    public $selectedBandeiras = [];
    
    protected $listeners = [
        'bandeiraCreated' => '$refresh',
        'bandeiraUpdated' => '$refresh',
        'entity-deleted' => '$refresh'
    ];

    public function getExportHeaders(): array
    {
        return [
            'ID',
            'Nome',
            'Grupo Econômico',
            'Criado em',
            'Atualizado em'
        ];
    }

    public function getExportData(): array
    {
        return Bandeira::with('grupoEconomico')
            ->get()
            ->map(fn ($bandeira) => [
                $bandeira->id,
                $bandeira->nome,
                $bandeira->grupoEconomico->nome,
                $bandeira->created_at->format('d/m/Y H:i:s'),
                $bandeira->updated_at->format('d/m/Y H:i:s')
            ])
            ->toArray();
    }

    public function getExportFilename(): string
    {
        return 'bandeiras';
    }

    public function getIsDisabledProperty()
    {
        return count($this->selectedBandeiras) === 0;
    }

    public function getSelectedCountProperty()
    {
        return count($this->selectedBandeiras);
    }

    protected function getModel()
    {
        return Bandeira::class;
    }

    public function deleteSelected()
    {
        if ($this->isDisabled) {
            return;
        }

        foreach ($this->selectedBandeiras as $id) {
            $this->confirmDelete($id);
            $this->delete();
        }
        
        $this->selectedBandeiras = [];
        session()->flash('message', 'Bandeiras selecionadas foram excluídas com sucesso!');
    }

    public function render()
    {
        return view('livewire.bandeiras', [
            'bandeiras' => Bandeira::with('grupoEconomico')->get(),
        ]);
    }
}
