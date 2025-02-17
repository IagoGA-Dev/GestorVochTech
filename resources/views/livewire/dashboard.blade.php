<div>
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8 max-w-full">
        {{-- Grupos Card --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg group hover:scale-105 transition-transform duration-300">
            <div class="p-4 lg:p-6 flex items-center space-x-3 lg:space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-building text-2xl text-gray-900 dark:text-white"></i>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-0.5 lg:mb-1">Grupos Econômicos</div>
                    <div class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">{{ $totalGrupos }}</div>
                </div>
            </div>
        </div>

        {{-- Bandeiras Card --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg group hover:scale-105 transition-transform duration-300">
            <div class="p-4 lg:p-6 flex items-center space-x-3 lg:space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-flag text-2xl text-gray-900 dark:text-white"></i>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-0.5 lg:mb-1">Bandeiras</div>
                    <div class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">{{ $totalBandeiras }}</div>
                </div>
            </div>
        </div>

        {{-- Unidades Card --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg group hover:scale-105 transition-transform duration-300">
            <div class="p-4 lg:p-6 flex items-center space-x-3 lg:space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-pink-100 dark:bg-pink-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-store text-2xl text-gray-900 dark:text-white"></i>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-0.5 lg:mb-1">Unidades</div>
                    <div class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">{{ $totalUnidades }}</div>
                </div>
            </div>
        </div>

        {{-- Colaboradores Card --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg group hover:scale-105 transition-transform duration-300">
            <div class="p-4 lg:p-6 flex items-center space-x-3 lg:space-x-4">
                <div class="flex-shrink-0 w-12 h-12 bg-orange-100 dark:bg-orange-900 rounded-lg flex items-center justify-center">
                    <i class="fas fa-users text-2xl text-gray-900 dark:text-white"></i>
                </div>
                <div>
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-0.5 lg:mb-1">Colaboradores</div>
                    <div class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white">{{ $totalColaboradores }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Pie Chart --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Unidades por Bandeira</h3>
            <div wire:ignore id="pieChart" class="h-80"></div>
        </div>

        {{-- Bar Chart --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Unidades por Grupo Econômico</h3>
            <div wire:ignore id="barChart" class="h-80"></div>
        </div>
    </div>

    {{-- Colaboradores Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Colaboradores por Unidade --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Colaboradores por Unidade</h3>
            <div wire:ignore id="colabUnidadeChart" class="h-80"></div>
        </div>

        {{-- Colaboradores por Bandeira --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Colaboradores por Bandeira</h3>
            <div wire:ignore id="colabBandeiraChart" class="h-80"></div>
        </div>

        {{-- Colaboradores por Grupo --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">Colaboradores por Grupo</h3>
            <div wire:ignore id="colabGrupoChart" class="h-80"></div>
        </div>
    </div>

    <script>
        function initCharts() {
            const chartData = {
                unidadesPorBandeira: @js($unidadesPorBandeira),
                unidadesPorGrupo: @js($unidadesPorGrupo),
                colaboradoresPorUnidade: @js($colaboradoresPorUnidade),
                colaboradoresPorBandeira: @js($colaboradoresPorBandeira),
                colaboradoresPorGrupo: @js($colaboradoresPorGrupo)
            };

            // Cores para os gráficos
            const colors = [
                '#4F46E5', '#7C3AED', '#EC4899', '#EF4444', '#F59E0B', 
                '#10B981', '#3B82F6', '#6366F1', '#8B5CF6', '#D946EF'
            ];

            // Configuração do tema
            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#F3F4F6' : '#1F2937';
            const gridColor = isDark ? '#374151' : '#E5E7EB';

            // Gráfico de Pizza - Unidades por Bandeira
            const pieChartOptions = {
                series: chartData.unidadesPorBandeira.map(b => b.value),
                chart: {
                    type: 'pie',
                    height: 320,
                    foreColor: textColor
                },
                labels: chartData.unidadesPorBandeira.map(b => b.name),
                colors: colors,
                legend: {
                    position: 'bottom'
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        chart: {
                            height: 280
                        }
                    }
                }]
            };

            // Configuração base para gráficos de barra horizontais
            const baseBarConfig = {
                chart: {
                    type: 'bar',
                    height: 320,
                    foreColor: textColor,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: true,
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    labels: {
                        style: {
                            colors: textColor
                        }
                    }
                },
                yaxis: {
                    labels: {
                        style: {
                            colors: textColor
                        }
                    }
                },
                grid: {
                    borderColor: gridColor,
                    xaxis: {
                        lines: {
                            show: true
                        }
                    }
                }
            };

            // Gráfico de Barras - Unidades por Grupo
            const barChartOptions = {
                ...baseBarConfig,
                series: [{
                    name: 'Unidades',
                    data: chartData.unidadesPorGrupo.map(g => g.value)
                }],
                xaxis: {
                    ...baseBarConfig.xaxis,
                    categories: chartData.unidadesPorGrupo.map(g => g.name)
                },
                colors: [colors[0]]
            };

            // Gráficos de Colaboradores
            const colabUnidadeOptions = {
                ...baseBarConfig,
                series: [{
                    name: 'Colaboradores',
                    data: chartData.colaboradoresPorUnidade.map(u => u.value)
                }],
                xaxis: {
                    ...baseBarConfig.xaxis,
                    categories: chartData.colaboradoresPorUnidade.map(u => u.name)
                },
                colors: [colors[1]]
            };

            const colabBandeiraOptions = {
                ...baseBarConfig,
                series: [{
                    name: 'Colaboradores',
                    data: chartData.colaboradoresPorBandeira.map(b => b.value)
                }],
                xaxis: {
                    ...baseBarConfig.xaxis,
                    categories: chartData.colaboradoresPorBandeira.map(b => b.name)
                },
                colors: [colors[2]]
            };

            const colabGrupoOptions = {
                ...baseBarConfig,
                series: [{
                    name: 'Colaboradores',
                    data: chartData.colaboradoresPorGrupo.map(g => g.value)
                }],
                xaxis: {
                    ...baseBarConfig.xaxis,
                    categories: chartData.colaboradoresPorGrupo.map(g => g.name)
                },
                colors: [colors[3]]
            };

            // Limpar gráficos existentes
            document.querySelectorAll('[id$="Chart"]').forEach(el => {
                el.innerHTML = '';
            });

            // Renderizar novos gráficos
            const pieChart = new ApexCharts(document.querySelector("#pieChart"), pieChartOptions);
            const barChart = new ApexCharts(document.querySelector("#barChart"), barChartOptions);
            const colabUnidadeChart = new ApexCharts(document.querySelector("#colabUnidadeChart"), colabUnidadeOptions);
            const colabBandeiraChart = new ApexCharts(document.querySelector("#colabBandeiraChart"), colabBandeiraOptions);
            const colabGrupoChart = new ApexCharts(document.querySelector("#colabGrupoChart"), colabGrupoOptions);

            pieChart.render();
            barChart.render();
            colabUnidadeChart.render();
            colabBandeiraChart.render();
            colabGrupoChart.render();

            // Atualizar gráficos quando o tema mudar
            Livewire.on('dark-mode-toggled', () => {
                const isDarkNew = document.documentElement.classList.contains('dark');
                const textColorNew = isDarkNew ? '#F3F4F6' : '#1F2937';
                const gridColorNew = isDarkNew ? '#374151' : '#E5E7EB';

                [pieChart, barChart, colabUnidadeChart, colabBandeiraChart, colabGrupoChart].forEach(chart => {
                    chart.updateOptions({
                        chart: {
                            foreColor: textColorNew
                        },
                        grid: {
                            borderColor: gridColorNew
                        }
                    });
                });
            });
        }

        // Inicializar gráficos na carga inicial
        document.addEventListener('livewire:initialized', initCharts);

        // Reinicializar gráficos ao navegar de volta para o dashboard
        document.addEventListener('livewire:navigated', () => {
            if (window.location.pathname === '/dashboard') {
                initCharts();
            }
        });
    </script>
</div>
