<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Bandeira;
use Illuminate\Support\Facades\DB;
use App\Traits\WithExport;

class Bandeiras extends Component
{
    use WithExport;

    public $selectedBandeiras = [];
    
    protected $listeners = [
        'bandeiraCreated' => '$refresh',
        'bandeiraUpdated' => '$refresh'
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

    public function deleteBandeira($bandeiraId)
    {
        $bandeira = Bandeira::with(['unidades'])->find($bandeiraId);
        $unidadesNomes = $bandeira->unidades->pluck('nome_fantasia')->toArray();
        
        if (count($unidadesNomes) > 0) {
            $mensagem = "As seguintes unidades serão removidas:\n";
            foreach ($unidadesNomes as $nome) {
                $mensagem .= "- " . $nome . "\n";
            }
            $mensagem .= "\nTem certeza que deseja excluir esta bandeira?";
            
            if (!$this->js("confirm(" . json_encode($mensagem) . ")")) {
                return;
            }
        }

        DB::beginTransaction();
        try {
            // Remover primeiro as unidades
            foreach ($bandeira->unidades as $unidade) {
                // Remover relacionamentos da unidade primeiro
                $unidade->colaboradores()->delete();
                $unidade->delete();
            }
            
            // Por fim, remover a bandeira
            $bandeira->delete();
            
            DB::commit();
            $this->dispatch('bandeiraCreated');
            session()->flash('message', 'Bandeira e suas unidades foram excluídas com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao excluir a bandeira: ' . $e->getMessage());
        }
    }

    public function deleteSelected()
    {
        if ($this->isDisabled) {
            return;
        }

        $bandeiras = Bandeira::with(['unidades'])->whereIn('id', $this->selectedBandeiras)->get();
        $mensagem = "As seguintes unidades serão removidas:\n\n";
        $temUnidades = false;

        foreach ($bandeiras as $bandeira) {
            if ($bandeira->unidades->count() > 0) {
                $temUnidades = true;
                $mensagem .= "Bandeira {$bandeira->nome}:\n";
                foreach ($bandeira->unidades as $unidade) {
                    $mensagem .= "- {$unidade->nome_fantasia}\n";
                }
                $mensagem .= "\n";
            }
        }

        if ($temUnidades) {
            $mensagem .= "Tem certeza que deseja excluir " . (count($this->selectedBandeiras) > 1 ? "estas bandeiras" : "esta bandeira") . "?";
            $confirmou = $this->js("confirm(" . json_encode($mensagem) . ")");
            if (!$confirmou) {
                return;
            }
        }

        DB::beginTransaction();
        try {
            foreach ($bandeiras as $bandeira) {
                // Remover primeiro as unidades
                foreach ($bandeira->unidades as $unidade) {
                    // Remover relacionamentos da unidade primeiro
                    $unidade->colaboradores()->delete();
                    $unidade->delete();
                }
                
                // Por fim, remover a bandeira
                $bandeira->delete();
            }
            
            DB::commit();
            $this->selectedBandeiras = [];
            session()->flash('message', 'Bandeiras e suas unidades foram excluídas com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao excluir as bandeiras: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.bandeiras', [
            'bandeiras' => Bandeira::with('grupoEconomico')->get(),
        ]);
    }
}
