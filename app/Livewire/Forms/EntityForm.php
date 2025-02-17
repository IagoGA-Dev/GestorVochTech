<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Illuminate\Validation\Rule;

class EntityForm extends Form
{
    public $entityName;
    public $entityModel;
    public $entityId;
    public $isEditing = false;
    
    // Campos comuns
    public $nome = '';
    
    // Campos de colaborador
    public $email = '';
    public $cpf = '';
    public $unidade_id = '';
    
    // Campos de unidade
    public $nome_fantasia = '';
    public $razao_social = '';
    public $cnpj = '';
    public $bandeira_id = '';
    
    // Campos de bandeira
    public $grupo_economico_id = '';
    
    public function setForEditing($entity)
    {
        $this->isEditing = true;
        $this->entityId = $entity->id;
        
        // Campos baseado no tipo de entidade
        switch ($this->entityName) {
            case 'grupo':
                $this->nome = $entity->nome;
                break;
                
            case 'colaborador':
                $this->nome = $entity->nome;
                $this->email = $entity->email;
                $this->cpf = $entity->cpf;
                $this->unidade_id = $entity->unidade_id;
                break;
                
            case 'unidade':
                $this->nome_fantasia = $entity->nome_fantasia;
                $this->razao_social = $entity->razao_social;
                $this->cnpj = $entity->cnpj;
                $this->bandeira_id = $entity->bandeira_id;
                break;
                
            case 'bandeira':
                $this->nome = $entity->nome;
                $this->grupo_economico_id = $entity->grupo_economico_id;
                break;
        }
    }

    public function rules()
    {
        $rules = [];
        
        switch ($this->entityName) {
            case 'grupo':
                $rules = [
                    'nome' => ['required', 'string', 'max:255'],
                ];
                break;

            case 'colaborador':
                $rules = [
                    'nome' => ['required', 'string', 'max:255'],
                    'email' => ['required', 'email', 'max:255', Rule::unique('colaboradores')->ignore($this->entityId)],
                    'cpf' => ['required', 'string', 'max:14', Rule::unique('colaboradores')->ignore($this->entityId)],
                    'unidade_id' => ['required', 'exists:unidades,id'],
                ];
                break;
                
            case 'unidade':
                $rules = [
                    'nome_fantasia' => ['required', 'string', 'max:255'],
                    'razao_social' => ['required', 'string', 'max:255'],
                    'cnpj' => ['required', 'string', 'max:18', Rule::unique('unidades')->ignore($this->entityId)],
                    'bandeira_id' => ['required', 'exists:bandeiras,id'],
                ];
                break;
                
            case 'bandeira':
                $rules = [
                    'nome' => ['required', 'string', 'max:255'],
                    'grupo_economico_id' => ['required', 'exists:grupo_economicos,id'],
                ];
                break;
        }
        
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'unique' => 'Este :attribute já está em uso',
            'exists' => 'O :attribute selecionado é inválido',
            'email' => 'O campo :attribute deve ser um endereço de e-mail válido',
            'max' => 'O campo :attribute não pode ter mais que :max caracteres',
        ];
    }
}
