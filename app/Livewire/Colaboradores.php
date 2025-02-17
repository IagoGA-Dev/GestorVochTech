<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Colaborador;
use Illuminate\Support\Facades\DB;
use App\Traits\WithExport;

class Colaboradores extends Component
{
    use WithExport;

    public $selectedColaboradores = [];
    
    protected $listeners = [
        'colaboradorCreated' => '$refresh',
        'colaboradorUpdated' => '$refresh'
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

    public function deleteColaborador($colaboradorId)
    {
        DB::beginTransaction();
        try {
            $colaborador = Colaborador::find($colaboradorId);
            $colaborador->delete();
            
            DB::commit();
            $this->dispatch('colaboradorCreated');
            session()->flash('message', 'Colaborador excluído com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao excluir o colaborador: ' . $e->getMessage());
        }
    }

    public function deleteSelected()
    {
        if ($this->isDisabled) {
            return;
        }

        DB::beginTransaction();
        try {
            Colaborador::whereIn('id', $this->selectedColaboradores)->delete();
            
            DB::commit();
            $this->selectedColaboradores = [];
            session()->flash('message', 'Colaboradores excluídos com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao excluir os colaboradores: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.colaboradores', [
            'colaboradores' => Colaborador::with(['unidade.bandeira.grupoEconomico'])->get(),
        ]);
    }
}
