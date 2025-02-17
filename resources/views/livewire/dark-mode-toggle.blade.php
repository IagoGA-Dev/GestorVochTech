<div 
    x-data="{ 
        darkMode: localStorage.getItem('darkMode') === 'true',
        init() {
            if (this.darkMode) {
                document.documentElement.classList.add('dark')
            }
            this.$watch('darkMode', value => {
                localStorage.setItem('darkMode', value)
                if (value) {
                    document.documentElement.classList.add('dark')
                } else {
                    document.documentElement.classList.remove('dark')
                }
                $wire.darkMode = value
                $wire.toggleDarkMode()
            })
        }
    }"
    class="flex items-center"
>
    <button
        @click="darkMode = !darkMode"
        type="button"
        class="relative inline-flex h-8 w-8 items-center justify-center rounded-md p-1.5 text-gray-500 transition hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300"
        :aria-label="darkMode ? 'Desativar modo escuro' : 'Ativar modo escuro'"
    >
        <i 
            class="fas transition-all" 
            :class="{
                'fa-sun text-amber-500 rotate-0 scale-100': !darkMode,
                'fa-moon text-indigo-500 rotate-90 scale-0': darkMode
            }"
            x-show="!darkMode"
        ></i>
        <i 
            class="fas transition-all" 
            :class="{
                'fa-moon text-indigo-500 rotate-0 scale-100': darkMode,
                'fa-sun text-amber-500 rotate-90 scale-0': !darkMode
            }"
            x-show="darkMode"
            x-transition:enter="transition-all duration-300"
        ></i>
    </button>
</div>
