<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Gestão</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet"/>

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gradient-to-br from-gray-50 to-green-50 dark:from-gray-900 dark:to-gray-800 min-h-screen">
<!-- Header -->
<header
    class="bg-white dark:bg-gray-800 sticky top-0 z-50 shadow-lg border-b border-green-100 dark:border-gray-700">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <x-application-logo size="md"/>
            <!-- Navegação Desktop -->
            <nav class="hidden md:flex space-x-8">
                <a href="/grupos"
                   class="text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 px-3 py-2 font-medium transition-colors border-b-2 border-transparent hover:border-green-500 dark:hover:border-green-400">
                    <i class="fas fa-users mr-2"></i>Grupos
                </a>
                <a href="/bandeiras"
                   class="text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 px-3 py-2 font-medium transition-colors border-b-2 border-transparent hover:border-green-500 dark:hover:border-green-400">
                    <i class="fas fa-flag mr-2"></i>Bandeiras
                </a>
                <a href="/unidades"
                   class="text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 px-3 py-2 font-medium transition-colors border-b-2 border-transparent hover:border-green-500 dark:hover:border-green-400">
                    <i class="fas fa-building mr-2"></i>Unidades
                </a>
                <a href="/colaboradores"
                   class="text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 px-3 py-2 font-medium transition-colors border-b-2 border-transparent hover:border-green-500 dark:hover:border-green-400">
                    <i class="fas fa-user-tie mr-2"></i>Colaboradores
                </a>
            </nav>

            <!-- Botão de Perfil -->
            <div class="hidden md:flex items-center space-x-4">
                @if (Route::has('login'))
                    <livewire:welcome.navigation/>
                @endif
                <!-- <livewire:light-switch /> -->
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <a href="/grupos"
                       class="text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 px-3 py-2 font-medium transition-colors border-b-2 border-transparent hover:border-green-500 dark:hover:border-green-400">
                        <i class="fas fa-users mr-2"></i>Grupos
                    </a>
                    <a href="/bandeiras"
                       class="text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 px-3 py-2 font-medium transition-colors border-b-2 border-transparent hover:border-green-500 dark:hover:border-green-400">
                        <i class="fas fa-flag mr-2"></i>Bandeiras
                    </a>
                    <a href="/unidades"
                       class="text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 px-3 py-2 font-medium transition-colors border-b-2 border-transparent hover:border-green-500 dark:hover:border-green-400">
                        <i class="fas fa-building mr-2"></i>Unidades
                    </a>
                    <a href="/colaboradores"
                       class="text-gray-600 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 px-3 py-2 font-medium transition-colors border-b-2 border-transparent hover:border-green-500 dark:hover:border-green-400">
                        <i class="fas fa-user-tie mr-2"></i>Colaboradores
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="container mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-16">
    <!-- Seção Hero -->
    <div class="max-w-4xl mx-auto text-center mb-24">
        <div class="mb-10">
                <span
                    class="bg-green-100 dark:bg-green-900 text-green-600 dark:text-green-300 px-6 py-2 rounded-full text-sm font-semibold">
                    Versão 1.0
                </span>
        </div>

        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white mb-6 leading-tight">
            Gestão Inteligente para seu Negócio
        </h1>

        <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 max-w-2xl mx-auto leading-relaxed">
            Controle completo de grupos econômicos, unidades empresariais e equipes. Tudo em uma plataforma
            integrada e intuitiva.
        </p>

        <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="/grupos"
               class="inline-flex items-center px-8 py-4 bg-green-600 hover:bg-green-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
                <i class="fas fa-rocket mr-3"></i>
                Começar Agora
            </a>
            <a href="#"
               class="inline-flex items-center px-8 py-4 bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg shadow-md hover:shadow-lg transition-shadow border border-gray-200 dark:border-gray-600 transform hover:-translate-y-1">
                <i class="fas fa-play-circle mr-3 text-green-500"></i>
                Ver Demonstração
            </a>
        </div>
    </div>

    <!-- Seção: Recursos -->
    <section
        class="py-16 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-700 bg-gradient-to-r from-green-50 via-white to-white dark:bg-gradient-to-r dark:from-gray-900 dark:via-gray-800 dark:to-gray-800 hover:shadow-lg transition-shadow duration-300">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-4">
                    Recursos Integrados
                </h2>
                <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                    Descubra as ferramentas poderosas que oferecemos para sua gestão empresarial
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Card 1 -->
                <div
                    class="p-6 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-white dark:hover:bg-gray-600 transition-all border border-transparent hover:border-green-100 dark:hover:border-green-900">
                    <div
                        class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-chart-line text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 dark:text-white">Dashboard Analítico</h3>
                    <p class="text-gray-600 dark:text-gray-300">Monitoramento em tempo real de todos os
                        indicadores-chave do seu negócio</p>
                </div>

                <!-- Card 2 -->
                <div
                    class="p-6 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-white dark:hover:bg-gray-600 transition-all border border-transparent hover:border-green-100 dark:hover:border-green-900">
                    <div
                        class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-file-invoice-dollar text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 dark:text-white">Relatórios Customizáveis</h3>
                    <p class="text-gray-600 dark:text-gray-300">Geração automática de relatórios financeiros e
                        operacionais com exportação em múltiplos formatos</p>
                </div>

                <!-- Card 3 -->
                <div
                    class="p-6 bg-gray-50 dark:bg-gray-700 rounded-xl hover:bg-white dark:hover:bg-gray-600 transition-all border border-transparent hover:border-green-100 dark:hover:border-green-900">
                    <div
                        class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-mobile-alt text-green-600 dark:text-green-400 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 dark:text-white">Acesso Mobile</h3>
                    <p class="text-gray-600 dark:text-gray-300">Plataforma totalmente responsiva e aplicativo
                        dedicado para acesso em qualquer lugar</p>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Footer -->
<footer class="bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="text-center md:flex md:items-center md:justify-between">
            <div class="text-gray-600 dark:text-gray-300">
                © {{ date('Y') }} GestãoPro.
            </div>

            <div class="mt-4 md:mt-0">
                <nav class="flex space-x-6 justify-center">
                    <a href="#"
                       class="text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#"
                       class="text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    <a href="#"
                       class="text-gray-500 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400">
                        <i class="fab fa-twitter"></i>
                    </a>
                    </a>
                </nav>
            </div>
        </div>
    </div>
</footer>

<!--  Scripts -->
<!-- <script>
        document.addEventListener('toggle-dark-mode', event => {
            document.documentElement.classList.toggle('dark', event.detail.isDarkMode);
        });

        document.addEventListener('DOMContentLoaded', () => {
            const isDarkMode = {{ session()->get('dark-mode', false) ? 'true' : 'false' }};
            document.documentElement.classList.toggle('dark', isDarkMode);

        });
    </script> -->

</body>

</html>
