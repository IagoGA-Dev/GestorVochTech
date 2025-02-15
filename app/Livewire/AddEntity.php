<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Unidade;
use App\Models\Bandeira;
use App\Models\GrupoEconomico;
use App\Livewire\Forms\EntityForm;
use Illuminate\Support\Facades\DB;

class AddEntity extends Component
{
    public $entityName;
    public $entityModel;
    public $modalName;

    public EntityForm $form;

    public function mount()
    {
        $this->modalName = 'create-' . $this->entityName;
        $this->form->entityName = $this->entityName;
        $this->form->entityModel = $this->entityModel;
    }

    public function createEntity()
    {
        $this->form->validate();

        try {
            DB::beginTransaction();
            
            $model = app($this->entityModel);

            switch ($this->entityName) {
                case 'grupo':
                    $model::create([
                        'nome' => $this->form->nome
                    ]);
                    break;

                case 'colaborador':
                    $model::create([
                        'nome' => $this->form->nome,
                        'email' => $this->form->email,
                        'cpf' => $this->form->cpf,
                        'unidade_id' => $this->form->unidade_id,
                    ]);
                    break;

                case 'unidade':
                    $model::create([
                        'nome_fantasia' => $this->form->nome_fantasia,
                        'razao_social' => $this->form->razao_social,
                        'cnpj' => $this->form->cnpj,
                        'bandeira_id' => $this->form->bandeira_id,
                    ]);
                    break;

                case 'bandeira':
                    $model::create([
                        'nome' => $this->form->nome,
                        'grupo_economico_id' => $this->form->grupo_economico_id,
                    ]);
                    break;
            }

            DB::commit();
            session()->flash('message', ucfirst($this->entityName) . ' criado(a) com sucesso!');
            
            $this->dispatch($this->entityName . 'Created');
            $this->js('show = false');
            $this->resetForm();

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Erro ao criar ' . $this->entityName . ': ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        $this->form->reset();
    }

    public function render()
    {
        $data = [];

        switch ($this->entityName) {
            case 'colaborador':
                $data['unidades'] = Unidade::all();
                break;
                
            case 'unidade':
                $data['bandeiras'] = Bandeira::all();
                break;
                
            case 'bandeira':
                $data['grupos'] = GrupoEconomico::all();
                break;
        }

        return view('livewire.add-entity', $data);
    }
}
