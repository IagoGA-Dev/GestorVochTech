<nav class="-mx-3 flex flex-1 justify-end">
    @auth
        <a
            href="{{ url('/dashboard') }}"
            class="text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 px-3 py-2 font-medium transition-colors border-b-2 border-transparent hover:border-green-500 dark:hover:border-green-400"
        >
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    @else
        <a
            href="{{ route('login') }}"
            class="text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 px-3 py-2 font-medium transition-colors border-b-2 border-transparent hover:border-green-500 dark:hover:border-green-400"
        >
            <i class="fas fa-sign-in-alt"></i> Log in
        </a>

        @if (Route::has('register'))
            <a
                href="{{ route('register') }}"
                class="text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 px-3 py-2 font-medium transition-colors border-b-2 border-transparent hover:border-green-500 dark:hover:border-green-400"
            >
                <i class="fas fa-user-plus"></i> Register
            </a>
        @endif
    @endauth
</nav>
