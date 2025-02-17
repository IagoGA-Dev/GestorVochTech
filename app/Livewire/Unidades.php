<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Unidade;
use Illuminate\Support\Facades\DB;
use App\Traits\WithExport;

class Unidades extends Component
{
    use WithExport;

    public $selectedUnidades = [];
    
    protected $listeners = [
        'unidadeCreated' => '$refresh',
        'unidadeUpdated' => '$refresh'
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
            'unidades' => Unidade::with(['bandeira.grupoEconomico'])->get(),
        ]);
    }
}
