<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Colaboradores') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @livewire('colaboradores')
                </div>
            </div>
        </div>
    </div>
    
    <script>
        function openModal() {
            const modal = document.getElementById('createColaboradorModal');
            const overlay = document.getElementById('modalOverlay');
            
            modal.style.display = 'block';
            setTimeout(() => {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                overlay.classList.remove('opacity-0');
            }, 50);
        }

        function closeModal() {
            const modal = document.getElementById('createColaboradorModal');
            const overlay = document.getElementById('modalOverlay');
            
            modal.classList.add('opacity-0', 'pointer-events-none');
            overlay.classList.add('opacity-0');
            
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Fecha o modal quando o evento closeModal é emitido pelo Livewire
        window.addEventListener('closeModal', event => {
            closeModal();
        });
    </script>
</x-app-layout>
