<div>
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h3 class="text-lg font-medium">Lista de Colaboradores</h3>
        <div class="flex flex-wrap gap-2 w-full sm:w-auto">
            <button 
                wire:click="deleteSelected" 
                @class([
                    'inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest transition ease-in-out duration-150',
                    'bg-red-600 text-white hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800' => !$this->isDisabled,
                    'bg-gray-300 text-gray-500 cursor-not-allowed dark:bg-gray-700 dark:text-gray-400' => $this->isDisabled
                ])
                @if($this->isDisabled) disabled @endif
                >
                <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Excluir @if($this->selectedCount > 0){{ $this->selectedCount }} @endif {{ $this->selectedCount == 1 ? 'selecionado' : 'selecionados' }}
            </button>
            
            <div class="flex flex-wrap gap-2 w-full sm:w-auto">
                <x-primary-button
                    x-data
                    @click="$dispatch('open-modal', 'create-colaborador')">
                    <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Adicionar novo colaborador
                </x-primary-button>

                <x-export-menu />
            </div>
        </div>
    </div>

    @if(session()->has('message'))
        <div class="mb-4 rounded-md bg-green-50 dark:bg-green-900 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">
                        {{ session('message') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    @if(session()->has('error'))
        <div class="mb-4 rounded-md bg-red-50 dark:bg-red-900 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800 dark:text-red-200">
                        {{ session('error') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
        @foreach($colaboradores as $colaborador)
            <li class="py-3 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 px-4 rounded-lg transition-colors duration-150">
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="selectedColaboradores" value="{{ $colaborador->id }}" class="mr-3 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                        <span class="text-blue-600 dark:text-blue-300 font-medium text-lg">
                            {{ strtoupper(substr($colaborador->nome, 0, 1)) }}
                        </span>
                    </div>
                    <div class="ml-4 flex-grow">
                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $colaborador->nome }}</p>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $colaborador->email }}</p>
                        <div class="mt-1 flex flex-wrap gap-2 text-xs">
                            @if($colaborador->unidade)
                                <span class="inline-flex items-center text-blue-600 dark:text-blue-400">
                                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ $colaborador->unidade->nome_fantasia }}
                                </span>
                            @endif
                            @if($colaborador->unidade?->bandeira)
                                <span class="inline-flex items-center text-purple-600 dark:text-purple-400">
                                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9" />
                                    </svg>
                                    {{ $colaborador->unidade->bandeira->nome }}
                                </span>
                            @endif
                            @if($colaborador->unidade?->bandeira?->grupoEconomico)
                                <span class="inline-flex items-center text-green-600 dark:text-green-400">
                                    <svg class="h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $colaborador->unidade->bandeira->grupoEconomico->nome }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button 
                        x-data
                        @click="$dispatch('open-modal', 'edit-colaborador-{{ $colaborador->id }}')"
                        class="text-blue-600 hover:text-blue-700">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                    <button 
                        wire:click="confirmDelete({{ $colaborador->id }})" 
                        type="button"
                        class="text-red-600 hover:text-red-700">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </div>
            </li>
        @endforeach
    </ul>

    {{-- Create Modal --}}
    <x-modal name="create-colaborador" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                Adicionar novo colaborador
            </h2>
            
            @livewire('add-entity', ['entityName' => 'colaborador', 'entityModel' => 'App\Models\Colaborador'])
        </div>
    </x-modal>

    {{-- Edit Modals --}}
    @foreach($colaboradores as $colaborador)
        <x-modal name="edit-colaborador-{{ $colaborador->id }}" focusable>
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Editar colaborador
                </h2>
                
                @livewire('edit-entity', [
                    'entityName' => 'colaborador',
                    'entityModel' => 'App\Models\Colaborador',
                    'entity' => $colaborador
                ], key('edit-colaborador-' . $colaborador->id))
            </div>
        </x-modal>
    @endforeach

    {{-- Delete Confirmation Modal --}}
    @if($showDeleteModal)
        <x-delete-modal>
            <x-slot:title>
                Confirmar Exclusão de Colaborador
            </x-slot>

            <p class="text-gray-600 dark:text-gray-300">
                Você está prestes a excluir o colaborador <strong>{{ $itemToDelete->nome }}</strong>.
                Esta ação não pode ser desfeita.
            </p>
        </x-delete-modal>
    @endif
</div>
