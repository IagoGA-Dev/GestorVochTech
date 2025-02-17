<?php

namespace App\Traits;

trait WithDelete
{
    public bool $showDeleteModal = false;
    public $itemToDelete = null;

    public function confirmDelete($id)
    {
        $this->resetDeleteState();
        $this->itemToDelete = $this->getModel()::find($id);
        if ($this->itemToDelete) {
            $this->showDeleteModal = true;
        }
    }

    public function delete()
    {
        if (!$this->itemToDelete) {
            return;
        }

        $item = $this->itemToDelete;

        // Record activity before deletion to capture related entities
        activity()
            ->performedOn($item)
            ->event('deleted')
            ->withProperties([
                'details' => $this->getDeleteActivityDetails()
            ])
            ->log('deleted');

        $item->delete();

        // Reset state before dispatching event
        $this->resetDeleteState();
        
        $this->dispatch('entity-deleted');
    }

    public function cancelDelete()
    {
        $this->resetDeleteState();
    }

    protected function resetDeleteState()
    {
        $this->showDeleteModal = false;
        $this->itemToDelete = null;
    }

    protected function getDeleteActivityDetails(): array
    {
        if (!$this->itemToDelete) {
            return [];
        }

        $model = strtolower(class_basename($this->itemToDelete));
        $details = [
            'id' => $this->itemToDelete->id,
            'name' => $this->itemToDelete->nome ?? $this->itemToDelete->nome_fantasia ?? '',
        ];

        // Add related entities information based on model type
        switch ($model) {
            case 'grupoeconomico':
                $details['bandeiras'] = $this->itemToDelete->bandeiras->map(function ($bandeira) {
                    return [
                        'id' => $bandeira->id,
                        'nome' => $bandeira->nome
                    ];
                })->toArray();
                $details['total_bandeiras'] = count($details['bandeiras']);
                break;

            case 'bandeira':
                $details['unidades'] = $this->itemToDelete->unidades->map(function ($unidade) {
                    return [
                        'id' => $unidade->id,
                        'nome' => $unidade->nome_fantasia
                    ];
                })->toArray();
                $details['total_unidades'] = count($details['unidades']);
                break;

            case 'unidade':
                $details['total_colaboradores'] = $this->itemToDelete->colaboradores->count();
                break;
        }

        return $details;
    }

    // Should be implemented by the component using this trait
    abstract protected function getModel();
}
