<?php

namespace App\Livewire;

use App\Models\Bandeira;
use App\Models\Colaborador;
use App\Models\GrupoEconomico;
use App\Models\Unidade;
use Livewire\Component;

class Dashboard extends Component
{
    public $totalGrupos;
    public $totalBandeiras;
    public $totalUnidades;
    public $totalColaboradores;
    public $unidadesPorBandeira;
    public $unidadesPorGrupo;
    public $colaboradoresPorUnidade;
    public $colaboradoresPorBandeira;
    public $colaboradoresPorGrupo;

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        // Contagens totais
        $this->totalGrupos = GrupoEconomico::count();
        $this->totalBandeiras = Bandeira::count();
        $this->totalUnidades = Unidade::count();
        $this->totalColaboradores = Colaborador::count();

        // Unidades por bandeira para gráfico de pizza
        $this->unidadesPorBandeira = Bandeira::withCount('unidades')
            ->having('unidades_count', '>', 0)
            ->get()
            ->map(fn($bandeira) => [
                'name' => $bandeira->nome,
                'value' => $bandeira->unidades_count
            ])
            ->toArray();

        // Colaboradores por unidade para gráfico de barras
        $this->colaboradoresPorUnidade = Unidade::withCount('colaboradores')
            ->having('colaboradores_count', '>', 0)
            ->get()
            ->map(fn($unidade) => [
                'name' => $unidade->nome_fantasia,
                'value' => $unidade->colaboradores_count
            ])
            ->toArray();

        // Colaboradores por bandeira para gráfico de barras
        $this->colaboradoresPorBandeira = Bandeira::with('unidades.colaboradores')
            ->get()
            ->map(fn($bandeira) => [
                'name' => $bandeira->nome,
                'value' => $bandeira->unidades->sum(fn($unidade) => $unidade->colaboradores->count())
            ])
            ->toArray();

        // Colaboradores por grupo para gráfico de barras
        $this->colaboradoresPorGrupo = GrupoEconomico::with('bandeiras.unidades.colaboradores')
            ->get()
            ->map(fn($grupo) => [
                'name' => $grupo->nome,
                'value' => $grupo->bandeiras->sum(
                    fn($bandeira) => $bandeira->unidades->sum(
                        fn($unidade) => $unidade->colaboradores->count()
                    )
                )
            ])
            ->toArray();

        // Unidades por grupo econômico para gráfico de barras
        $this->unidadesPorGrupo = GrupoEconomico::with('bandeiras.unidades')
            ->get()
            ->map(fn($grupo) => [
                'name' => $grupo->nome,
                'value' => $grupo->bandeiras->sum(fn($bandeira) => $bandeira->unidades->count())
            ])
            ->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
