<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Stats Cards Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 mb-6">
                    <!-- Current Achievement Card -->
                    <div class="bg-gradient-to-r from-amber-400 to-orange-500 rounded-xl p-6 text-white shadow-lg">
                        <h3 class="text-lg font-semibold mb-2">JUMLAH CAPAIAN KBPP SAAT INI</h3>
                        <div class="text-4xl font-bold mb-1">67</div>
                        <div class="text-2xl font-semibold">27.80%</div>
                        <div class="text-sm mt-2 opacity-90">KECAMATAN DOLO</div>
                    </div>

                    <!-- Target Achievement Card -->
                    <div class="bg-gradient-to-r from-teal-400 to-cyan-500 rounded-xl p-6 text-white shadow-lg">
                        <h3 class="text-lg font-semibold mb-2">JUMLAH CAPAIAN KBPP MKJP SAAT INI</h3>
                        <div class="text-4xl font-bold mb-1">42</div>
                        <div class="text-2xl font-semibold">34.43%</div>
                        <div class="text-sm mt-2 opacity-90">KECAMATAN DOLO</div>
                    </div>

                    <!-- Status Card -->
                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl p-6 text-white shadow-lg">
                        <h3 class="text-lg font-semibold mb-2">STATUS TARGET</h3>
                        <div class="text-4xl font-bold mb-1">174</div>
                        <div class="text-lg">Total Target</div>
                        <div class="text-sm mt-2 opacity-90">AGUSTUS 2025</div>
                    </div>
                </div>

                <!-- Charts Row -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
                    <!-- Monthly Progress Chart -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">PENINGKATAN CAPAIAN KBPP S/D AGUSTUS 2025</h3>
                        <div id="monthly-chart" class="h-80"></div>
                    </div>

                    <!-- Target vs Achievement Chart -->
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">TARGET vs. CAPAIAN KBPP S/D AGUSTUS 2025</h3>
                        <div id="target-chart" class="h-80"></div>
                    </div>
                </div>


                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Monthly Progress Chart
        const monthlyOptions = {
            series: [{
                name: "Capaian KBPP",
                data: [11, 38, 40, 43, 62, 63, 64, 67],
                color: "#e74c3c"
            }],
            chart: {
                type: "bar",
                height: 320,
                toolbar: { show: false },
                background: 'transparent'
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: "55%",
                    borderRadius: 8,
                    dataLabels: {
                        position: "top"
                    }
                }
            },
            dataLabels: {
                enabled: true,
                offsetY: -20,
                style: {
                    fontSize: "12px",
                    colors: ["#304758"],
                    fontWeight: "bold"
                }
            },
            xaxis: {
                categories: ["JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS"],
                labels: {
                    style: {
                        colors: "#6b7280",
                        fontSize: "11px"
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                max: 80,
                labels: {
                    style: {
                        colors: "#6b7280",
                        fontSize: "11px"
                    }
                }
            },
            grid: {
                show: true,
                borderColor: "#f3f4f6",
                strokeDashArray: 2
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return value + " capaian"
                    }
                }
            }
        };

        // Target vs Achievement Chart
        const targetOptions = {
            series: [67, 107],
            chart: {
                type: 'donut',
                height: 320,
                toolbar: { show: false }
            },
            labels: ['Capaian', 'Sisa Target'],
            colors: ['#3b82f6', '#f87171'],
            dataLabels: {
                enabled: true,
                formatter: function(val, opts) {
                    return opts.w.config.series[opts.seriesIndex]
                },
                style: {
                    fontSize: '16px',
                    fontWeight: 'bold',
                    colors: ['#fff']
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '16px',
                                fontWeight: 600,
                                color: '#374151'
                            },
                            value: {
                                show: true,
                                fontSize: '24px',
                                fontWeight: 'bold',
                                color: '#111827'
                            },
                            total: {
                                show: true,
                                label: 'Total Target',
                                fontSize: '14px',
                                color: '#6b7280',
                                formatter: function() {
                                    return '174'
                                }
                            }
                        }
                    }
                }
            },
            legend: {
                position: 'bottom',
                fontSize: '14px',
                fontWeight: 500,
                labels: {
                    colors: '#374151'
                }
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return value + " (" + ((value/174)*100).toFixed(1) + "%)"
                    }
                }
            }
        };

        // Original Profit Chart
        const profitOptions = {
            series: [
                {
                    name: "Income",
                    color: "#31C48D",
                    data: [1420, 1620, 1820, 1420, 1650, 2120],
                },
                {
                    name: "Expense",
                    data: [788, 810, 866, 788, 1100, 1200],
                    color: "#F05252",
                }
            ],
            chart: {
                sparkline: { enabled: false },
                type: "bar",
                width: "100%",
                height: 400,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    columnWidth: "100%",
                    borderRadiusApplication: "end",
                    borderRadius: 6,
                    dataLabels: { position: "top" }
                }
            },
            legend: {
                show: true,
                position: "bottom"
            },
            dataLabels: { enabled: false },
            tooltip: {
                shared: true,
                intersect: false,
                formatter: function (value) {
                    return "$" + value
                }
            },
            xaxis: {
                labels: {
                    show: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                    },
                    formatter: function(value) {
                        return "$" + value
                    }
                },
                categories: ["Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                axisTicks: { show: false },
                axisBorder: { show: false }
            },
            yaxis: {
                labels: {
                    show: true,
                    style: {
                        fontFamily: "Inter, sans-serif",
                        cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                    }
                }
            },
            grid: {
                show: true,
                strokeDashArray: 4,
                padding: {
                    left: 2,
                    right: 2,
                    top: -20
                }
            },
            fill: { opacity: 1 }
        };

        // Render Charts
        if(document.getElementById("monthly-chart")) {
            const monthlyChart = new ApexCharts(document.getElementById("monthly-chart"), monthlyOptions);
            monthlyChart.render();
        }

        if(document.getElementById("target-chart")) {
            const targetChart = new ApexCharts(document.getElementById("target-chart"), targetOptions);
            targetChart.render();
        }

        if(document.getElementById("bar-chart") && typeof ApexCharts !== 'undefined') {
            const profitChart = new ApexCharts(document.getElementById("bar-chart"), profitOptions);
            profitChart.render();
        }
    });
    </script>
    @endpush
</x-app-layout>
