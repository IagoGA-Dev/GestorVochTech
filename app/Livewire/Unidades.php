<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Unidade;
use App\Traits\WithExport;
use App\Traits\WithDelete;

class Unidades extends Component
{
    use WithExport, WithDelete;

    public $selectedUnidades = [];
    
    protected $listeners = [
        'unidadeCreated' => '$refresh',
        'unidadeUpdated' => '$refresh',
        'entity-deleted' => '$refresh'
    ];

    public function getExportHeaders(): array
    {
        return [
            'ID',
            'Nome Fantasia',
            'Razão Social',
            'CNPJ',
            'Bandeira',
            'Grupo Econômico',
            'Criado em',
            'Atualizado em'
        ];
    }

    public function getExportData(): array
    {
        return Unidade::with(['bandeira.grupoEconomico'])
            ->get()
            ->map(fn ($unidade) => [
                $unidade->id,
                $unidade->nome_fantasia,
                $unidade->razao_social,
                $unidade->cnpj,
                $unidade->bandeira->nome,
                $unidade->bandeira->grupoEconomico->nome,
                $unidade->created_at->format('d/m/Y H:i:s'),
                $unidade->updated_at->format('d/m/Y H:i:s')
            ])
            ->toArray();
    }

    public function getExportFilename(): string
    {
        return 'unidades';
    }

    public function getIsDisabledProperty()
    {
        return count($this->selectedUnidades) === 0;
    }

    public function getSelectedCountProperty()
    {
        return count($this->selectedUnidades);
    }

    protected function getModel()
    {
        return Unidade::class;
    }

    public function deleteSelected()
    {
        if ($this->isDisabled) {
            return;
        }

        foreach ($this->selectedUnidades as $id) {
            $this->confirmDelete($id);
            $this->delete();
        }
        
        $this->selectedUnidades = [];
        session()->flash('message', 'Unidades selecionadas foram excluídas com sucesso!');
    }

    public function render()
    {
        return view('livewire.unidades', [
            'unidades' => Unidade::with(['bandeira.grupoEconomico'])->get(),
        ]);
    }
}
