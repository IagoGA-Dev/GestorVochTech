<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Unidade;
use App\Models\Bandeira;
use App\Models\GrupoEconomico;
use App\Livewire\Forms\EntityForm;
use Illuminate\Support\Facades\DB;

class EditEntity extends Component
{
    public $entityName;
    public $entityModel;
    public $modalName;
    public $modalTitle;

    public EntityForm $form;

    protected $listeners = ['refreshForm' => 'resetForm'];

    public function mount($entityName, $entityModel, $entity = null)
    {
        $this->entityName = $entityName;
        $this->entityModel = $entityModel;
        
        $this->modalName = $entity ? 'edit-' . $entityName . '-' . $entity->id : 'create-' . $entityName;
        $this->modalTitle = ($entity ? 'Editar ' : 'Adicionar novo ') . match($entityName) {
            'grupo' => 'grupo',
            'bandeira' => 'bandeira',
            'unidade' => 'unidade',
            'colaborador' => 'colaborador',
        };

        $this->form->entityName = $this->entityName;
        $this->form->entityModel = $this->entityModel;

        if ($entity) {
            $this->form->setForEditing($entity);
        }
    }

    public function save()
    {
        $this->form->validate();

        try {
            DB::beginTransaction();
            
            $model = $this->form->isEditing 
                ? app($this->entityModel)->find($this->form->entityId)
                : app($this->entityModel);

            $data = match($this->entityName) {
                'grupo' => [
                    'nome' => $this->form->nome
                ],
                'colaborador' => [
                    'nome' => $this->form->nome,
                    'email' => $this->form->email,
                    'cpf' => $this->form->cpf,
                    'unidade_id' => $this->form->unidade_id,
                ],
                'unidade' => [
                    'nome_fantasia' => $this->form->nome_fantasia,
                    'razao_social' => $this->form->razao_social,
                    'cnpj' => $this->form->cnpj,
                    'bandeira_id' => $this->form->bandeira_id,
                ],
                'bandeira' => [
                    'nome' => $this->form->nome,
                    'grupo_economico_id' => $this->form->grupo_economico_id,
                ],
            };

            if ($this->form->isEditing) {
                $model->update($data);
            } else {
                $model::create($data);
            }

            DB::commit();
            $action = $this->form->isEditing ? 'atualizado' : 'criado';
            session()->flash('message', ucfirst($this->entityName) . " {$action}(a) com sucesso!");
            
            $this->dispatch($this->entityName . ($this->form->isEditing ? 'Updated' : 'Created'));
            $this->js('show = false');
            $this->resetForm();

        } catch (\Exception $e) {
            DB::rollBack();
            $action = $this->form->isEditing ? 'atualizar' : 'criar';
            session()->flash('error', "Erro ao {$action} " . $this->entityName . ': ' . $e->getMessage());
        }
    }

    public function resetForm()
    {
        if ($this->form->isEditing) {
            $this->form->setForEditing(app($this->entityModel)->find($this->form->entityId));
        } else {
            $this->form->reset();
        }
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

        return view('livewire.edit-entity', $data);
    }
}
