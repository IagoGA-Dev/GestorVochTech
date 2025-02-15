<div>
    <form wire:submit.prevent="createEntity" class="space-y-6">
        <div>
            <label for="entityValue" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                <i class="fas fa-plus-circle mr-2"></i>Nome da {{ $entityName }}
            </label>

            <div class="mt-1 relative rounded-md shadow-sm">
                <input
                    type="text"
                    id="entityValue"
                    wire:model="entityValue"
                    class="block w-full pl-10 pr-4 py-3 border-2 border-gray-200 dark:border-gray-600 rounded-lg focus:ring-4 focus:ring-blue-200 focus:border-blue-500 dark:focus:ring-blue-500/20 dark:focus:border-blue-500 sm:text-sm dark:bg-gray-800 dark:text-gray-100 transition-all"
                    placeholder="Digite o nome da {{ $entityName }}">
                @error('entityValue')
                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                @enderror
            </div>
            @error('entityValue')
            <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                <i class="fas fa-exclamation-triangle mr-2"></i>{{ $message }}
            </p>
            @enderror
        </div>

        <div class="flex justify-end gap-4 pt-4 border-t border-gray-200 dark:border-gray-700 b-4">
            <button
                type="button"
                onclick="closeModal()"
                class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg shadow-md transition-all">
                <i class="fas fa-times-circle mr-2"></i>
                Cancelar
            </button>
            <button
                type="submit"
                class="inline-flex items-center px-8 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-md transition-all">
                <i class="fas fa-check-circle mr-2"></i>
                Confirmar
            </button>
        </div>
    </form>
</div>