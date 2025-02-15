<div>
    <div class="mb-6 flex justify-between items-center">
        <h3 class="text-lg font-medium">Lista de Bandeiras</h3>
        <div class="flex gap-2">
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
                Excluir @if($this->selectedCount > 0){{ $this->selectedCount }} @endif {{ $this->selectedCount == 1 ? 'selecionada' : 'selecionadas' }}
            </button>
            
            <button onclick="openModal()" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Adicionar nova bandeira
            </button>
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
        @foreach($bandeiras as $bandeira)
            <li class="py-3 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700 px-4 rounded-lg transition-colors duration-150">
                <div class="flex items-center">
                    <input type="checkbox" wire:model.live="selectedBandeiras" value="{{ $bandeira->id }}" class="mr-3 rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center">
                        <span class="text-blue-600 dark:text-blue-300 font-medium text-lg">
                            {{ strtoupper(substr($bandeira->nome, 0, 1)) }}
                        </span>
                    </div>
                    <div class="ml-4 flex-grow">
                        @if($editingBandeiraId === $bandeira->id)
                            <div class="flex items-center gap-2">
                                <input type="text" 
                                    wire:model="editingBandeiraNome" 
                                    class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm"
                                    placeholder="Nome da bandeira">
                                <button wire:click="saveEdit" class="text-green-600 hover:text-green-700">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                                <button wire:click="cancelEdit" class="text-red-600 hover:text-red-700">
                                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        @else
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $bandeira->nome }}</p>
                        @endif
                    </div>
                </div>
                @if($editingBandeiraId !== $bandeira->id)
                    <div class="flex items-center gap-2">
                        <button wire:click="startEdit({{ $bandeira->id }})" class="text-blue-600 hover:text-blue-700">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </button>
                        <button 
                            wire:click="deleteBandeira({{ $bandeira->id }})" 
                            type="button"
                            class="text-red-600 hover:text-red-700">
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                @endif
            </li>
        @endforeach
    </ul>

    <div id="createBandeiraModal" class="fixed z-50 inset-0 overflow-y-auto opacity-0 pointer-events-none transition-all duration-300 ease-out" style="display:none;">
        <!-- Overlay -->
        <div class="fixed inset-0" aria-hidden="true">
            <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 transition-opacity duration-300 ease-in-out opacity-0 will-change-opacity" 
                 id="modalOverlay"
                 onclick="closeModal()"></div>
        </div>

        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <!-- Modal -->
            <div class="relative inline-block align-bottom bg-white dark:bg-gray-900 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border dark:border-gray-700 scale-95 transition-transform duration-300"
                 onclick="event.stopPropagation()"> <!-- Impede que cliques no modal propaguem para o overlay -->
                <div class="bg-white dark:bg-gray-900 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">
                                Adicionar nova bandeira
                            </h3>
                            @livewire('add-entity', ['entityName' => 'bandeira', 'entityModel' => 'App\Models\Bandeira', 'entityField' => 'nome'])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>