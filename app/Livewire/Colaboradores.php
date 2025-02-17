<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Colaborador;
use Illuminate\Support\Facades\DB;

class Colaboradores extends Component
{
    public $selectedColaboradores = [];
    
    protected $listeners = [
        'colaboradorCreated' => '$refresh',
        'colaboradorUpdated' => '$refresh'
    ];

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
