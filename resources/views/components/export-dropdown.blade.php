@props(['modalTarget'])

<div class="flex gap-2">
    <x-primary-button
        x-data
        @click="$dispatch('open-modal', '{{ $modalTarget }}')">
        <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
        {{ $slot }}
    </x-primary-button>

    <div class="relative" x-data="{ open: false }">
        <button
            @click="open = !open"
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
        >
            <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
            </svg>
            Exportar
            <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>

        <div
            x-show="open"
            @click.away="open = false"
            class="absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100 focus:outline-none z-50"
            role="menu"
        >
            <div class="py-1" role="none">
                <button
                    wire:click="exportCsv"
                    class="text-gray-700 group flex items-center px-4 py-2 text-sm w-full hover:bg-gray-100"
                    role="menuitem"
                >
                    <i class="fas fa-file-csv mr-3 text-gray-400 group-hover:text-gray-500"></i>
                    Exportar CSV
                </button>
                <button
                    wire:click="exportXlsx"
                    class="text-gray-700 group flex items-center px-4 py-2 text-sm w-full hover:bg-gray-100"
                    role="menuitem"
                >
                    <i class="fas fa-file-excel mr-3 text-gray-400 group-hover:text-gray-500"></i>
                    Exportar Excel
                </button>
            </div>
        </div>
    </div>
</div>
