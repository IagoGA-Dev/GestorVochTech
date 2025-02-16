<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Grupos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @livewire('grupos')
                </div>
            </div>
        </div>
    </div>

    <div id="createGrupoModal" class="fixed z-50 inset-0 overflow-y-auto opacity-0 pointer-events-none transition-all duration-300 ease-out" style="display:none;">
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
                                Adicionar novo grupo
                            </h3>
                            <div class="mt-4 mb-4 w-full">
                                @livewire('create-grupo')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('createGrupoModal');
        const overlay = document.getElementById('modalOverlay');
        
        function openModal() {
            modal.style.display = 'block';
            requestAnimationFrame(() => {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                modal.querySelector('.transform').classList.remove('scale-95');
                overlay.style.opacity = '0.75';
            });
        }
        
        function closeModal() {
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.querySelector('.transform').classList.add('scale-95');
            overlay.style.opacity = '0';
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        // Garantindo que o Livewire está inicializado antes de adicionar o listener
        if (typeof Livewire !== 'undefined') {
            Livewire.on('grupoCreated', () => {
                closeModal();
            });
        } else {
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('grupoCreated', () => {
                    closeModal();
                });
            });
        }

        // Fechar o modal com a tecla ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('opacity-0')) closeModal();
        });
    </script>
</x-app-layout>