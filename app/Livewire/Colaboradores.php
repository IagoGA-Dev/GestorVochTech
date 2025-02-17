<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Colaborador;
use App\Traits\WithExport;
use App\Traits\WithDelete;

class Colaboradores extends Component
{
    use WithExport, WithDelete;

    public $selectedColaboradores = [];
    
    protected $listeners = [
        'colaboradorCreated' => '$refresh',
        'colaboradorUpdated' => '$refresh',
        'entity-deleted' => '$refresh'
    ];

    public function getExportHeaders(): array
    {
        return [
            'ID',
            'Nome',
            'Email',
            'CPF',
            'Unidade',
            'Bandeira',
            'Grupo Econômico',
            'Criado em',
            'Atualizado em'
        ];
    }

    public function getExportData(): array
    {
        return Colaborador::with(['unidade.bandeira.grupoEconomico'])
            ->get()
            ->map(fn ($colaborador) => [
                $colaborador->id,
                $colaborador->nome,
                $colaborador->email,
                $colaborador->cpf,
                $colaborador->unidade->nome_fantasia,
                $colaborador->unidade->bandeira->nome,
                $colaborador->unidade->bandeira->grupoEconomico->nome,
                $colaborador->created_at->format('d/m/Y H:i:s'),
                $colaborador->updated_at->format('d/m/Y H:i:s')
            ])
            ->toArray();
    }

    public function getExportFilename(): string
    {
        return 'colaboradores';
    }

    public function getIsDisabledProperty()
    {
        return count($this->selectedColaboradores) === 0;
    }

    public function getSelectedCountProperty()
    {
        return count($this->selectedColaboradores);
    }

    protected function getModel()
    {
        return Colaborador::class;
    }

    public function deleteSelected()
    {
        if ($this->isDisabled) {
            return;
        }

        foreach ($this->selectedColaboradores as $id) {
            $this->confirmDelete($id);
            $this->delete();
        }
        
        $this->selectedColaboradores = [];
        session()->flash('message', 'Colaboradores selecionados foram excluídos com sucesso!');
    }

    public function render()
    {
        return view('livewire.colaboradores', [
            'colaboradores' => Colaborador::with(['unidade.bandeira.grupoEconomico'])->get(),
        ]);
    }
}
