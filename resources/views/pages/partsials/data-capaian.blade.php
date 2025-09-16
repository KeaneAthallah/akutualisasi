<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KBPP Dashboard</title>
    <link rel="icon" type="image/png" href="{{ asset('./logo.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-6 flex items-center justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard KBPP</h2>
                    <!-- Back Button -->
                    <button onclick="history.back()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                        ← Kembali
                    </button>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <!-- Filters -->
                    <form id="filterForm"
                        class="p-4 md:p-6 flex flex-col md:flex-row gap-4 md:gap-6 mb-6 bg-white rounded-lg shadow-sm">
                        <!-- Kabupaten -->
                        <div class="w-full md:w-64">
                            <label for="kabupaten_id" class="block text-sm font-medium text-gray-700">Kabupaten</label>
                            <select id="kabupaten_id" name="kabupaten_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Semua Kabupaten --</option>
                            </select>
                        </div>

                        <!-- Kecamatan -->
                        <div class="w-full md:w-64">
                            <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                            <select id="kecamatan_id" name="kecamatan_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">-- Semua Kecamatan --</option>
                            </select>
                        </div>

                        <div class="flex items-end w-full md:w-auto">
                            <button type="button" id="filterBtn"
                                class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                Filter
                            </button>
                        </div>
                    </form>

                    <!-- Loading indicator -->
                    <div id="loadingIndicator" class="text-center p-6">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                        <p class="mt-2 text-gray-600">Loading data...</p>
                    </div>

                    <!-- Stats Cards -->
                    <div id="statsCards" class="grid grid-cols-3 md:grid-cols-3 gap-6 p-6 " style="display: none;">

                        <div
                            class="bg-gradient-to-r from-amber-400 to-orange-500 rounded-xl p-6 text-white shadow-lg mb-2">
                            <h3 class="text-lg font-semibold mb-2">JUMLAH CAPAIAN KBPP SAAT INI</h3>
                            <div id="totalCapaian" class="text-4xl font-bold mb-1">0</div>
                            <div id="percentageCapaian" class="text-2xl font-semibold">0%</div>
                        </div>



                        <div class="bg-gradient-to-r from-teal-400 to-cyan-500 rounded-xl p-4 text-white shadow-lg">
                            <h3 class="text-lg font-semibold mb-1">CAPAIAN MKJP</h3>
                            <div id="totalCapaianMkjp" class="text-4xl font-bold mb-1">0</div>
                            <div id="percentageCapaianMkjp" class="text-2xl font-semibold">0%</div>
                        </div>

                        <div
                            class="hidden bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl p-4 text-white shadow-lg">
                            <h3 class="text-lg font-semibold mb-1">STATUS TARGET</h3>
                            <div id="totalTarget" class="text-4xl font-bold mb-1">0</div>
                            <div class="text-sm">Total Target</div>
                        </div>

                    </div>

                    <!-- Charts -->
                    <div id="chartsContainer" class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6" style="display: none;">
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">PENINGKATAN CAPAIAN KBPP</h3>
                            <div id="monthly-chart" class="h-80"></div>
                        </div>

                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">TARGET vs. CAPAIAN KBPP</h3>
                            <div id="target-chart" class="h-80"></div>
                        </div>
                    </div>

                    <!-- Error message -->
                    <div id="errorMessage" class="text-center p-6 text-red-600" style="display: none;">
                        <p>Failed to load data. Please try again.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JS is the same as before -->
    <script>
        let monthlyChart, targetChart;

        document.addEventListener('DOMContentLoaded', function() {
            const kabupatenSelect = document.getElementById('kabupaten_id');
            const kecamatanSelect = document.getElementById('kecamatan_id');
            const filterBtn = document.getElementById('filterBtn');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const statsCards = document.getElementById('statsCards');
            const chartsContainer = document.getElementById('chartsContainer');
            const errorMessage = document.getElementById('errorMessage');

            // Load initial data
            loadDashboardData();

            // Event listeners
            kabupatenSelect.addEventListener('change', function() {
                loadKecamatans(this.value);
            });

            filterBtn.addEventListener('click', function() {
                loadDashboardData();
            });

            // Load kecamatans based on selected kabupaten
            async function loadKecamatans(kabupatenId) {
                if (!kabupatenId) {
                    kecamatanSelect.innerHTML = '<option value="">-- Semua Kecamatan --</option>';
                    return;
                }

                try {
                    const response = await fetch(`/get-kecamatan/${kabupatenId}`);
                    const kecamatans = await response.json();

                    kecamatanSelect.innerHTML = '<option value="">-- Semua Kecamatan --</option>';
                    kecamatans.forEach(kecamatan => {
                        const option = document.createElement('option');
                        option.value = kecamatan.id;
                        option.textContent = kecamatan.name;
                        kecamatanSelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error loading kecamatans:', error);
                }
            }

            // Load dashboard data from API
            async function loadDashboardData() {
                showLoading(true);

                try {
                    const kabupatenId = kabupatenSelect.value;
                    const kecamatanId = kecamatanSelect.value;

                    const params = new URLSearchParams();
                    if (kabupatenId) params.append('kabupaten_id', kabupatenId);
                    if (kecamatanId) params.append('kecamatan_id', kecamatanId);

                    const response = await fetch(`/api/dashboard-data?${params.toString()}`);

                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }

                    const data = await response.json();

                    // Populate kabupaten dropdown if it's empty
                    if (kabupatenSelect.children.length === 1) {
                        data.allKabupatens.forEach(kabupaten => {
                            const option = document.createElement('option');
                            option.value = kabupaten.id;
                            option.textContent = kabupaten.name;
                            kabupatenSelect.appendChild(option);
                        });
                    }

                    updateDashboard(data);
                    showLoading(false);

                } catch (error) {
                    console.error('Error loading dashboard data:', error);
                    showError(true);
                    showLoading(false);
                }
            }

            // Show/hide loading indicator
            function showLoading(show) {
                loadingIndicator.style.display = show ? 'block' : 'none';
                statsCards.style.display = show ? 'none' : 'block';
                chartsContainer.style.display = show ? 'none' : 'block';
                errorMessage.style.display = 'none';
            }

            // Show error message
            function showError(show) {
                errorMessage.style.display = show ? 'block' : 'none';
                statsCards.style.display = 'none';
                chartsContainer.style.display = 'none';
            }

            // Update dashboard with API data
            function updateDashboard(data) {
                // Update stats cards
                document.getElementById('totalCapaian').textContent = (data.totalCapaian || 0).toLocaleString();
                document.getElementById('totalTarget').textContent = (data.totalTarget || 0).toLocaleString();
                document.getElementById('totalCapaianMkjp').textContent = (data.totalCapaianMkjp || 0)
                    .toLocaleString();

                const percentageKbpp = data.totalTarget > 0 ? ((data.totalCapaian / data.totalTarget) * 100)
                    .toFixed(2) : 0;
                const percentageMkjp = data.totalTargetMkjp > 0 ? ((data.totalCapaianMkjp / data.totalTargetMkjp) *
                    100).toFixed(2) : 0;

                document.getElementById('percentageCapaian').textContent = percentageKbpp + '%';
                document.getElementById('percentageCapaianMkjp').textContent = percentageMkjp + '%';

                // Update charts
                updateCharts(data);
            }

            // Update charts
            function updateCharts(data) {
                // Prepare monthly data
                const monthlyData = data.monthlyData || {};
                const monthlyValues = Object.values(monthlyData);
                const monthlyCategories = Object.keys(monthlyData);

                // If no monthly data, create empty arrays
                if (monthlyValues.length === 0) {
                    monthlyValues.push(0);
                    monthlyCategories.push('No Data');
                }

                // Destroy existing charts
                if (monthlyChart) monthlyChart.destroy();
                if (targetChart) targetChart.destroy();

                // Monthly Progress Chart
                const monthlyOptions = {
                    series: [{
                        name: "Capaian KBPP",
                        data: monthlyValues,
                        color: "#e74c3c"
                    }],
                    chart: {
                        type: "bar",
                        height: 320,
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    tooltip: {
                        enabled: false
                    }, // disable tooltip
                    states: {
                        hover: {
                            filter: {
                                type: 'none'
                            }
                        }, // disable hover effect
                        active: {
                            filter: {
                                type: 'none'
                            }
                        } // disable click highlight
                    },
                    markers: {
                        hover: {
                            size: 0
                        }
                    }, // prevent marker enlargement
                    xaxis: {
                        categories: monthlyCategories,
                        labels: {
                            style: {
                                colors: '#64748b',
                                fontSize: '12px'
                            }
                        }
                    },
                    yaxis: {
                        labels: {
                            style: {
                                colors: '#64748b',
                                fontSize: '12px'
                            },
                            formatter: function(value) {
                                return value.toLocaleString();
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        style: {
                            fontSize: '10px',
                            fontWeight: 'bold',
                            colors: ['#fff']
                        }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            dataLabels: {
                                position: 'top'
                            }
                        }
                    },
                    grid: {
                        show: true,
                        borderColor: '#e2e8f0',
                        strokeDashArray: 0,
                        position: 'back'
                    },
                    noData: {
                        text: 'No data available'
                    }
                };

                monthlyChart = new ApexCharts(document.getElementById("monthly-chart"), monthlyOptions);
                monthlyChart.render();

                // Target vs Capaian Chart
                const totalCapaian = data.totalCapaian || 0;
                const totalTarget = data.totalTarget || 0;
                const sisaTarget = Math.max(0, totalTarget - totalCapaian);

                const targetOptions = {
                    series: [totalCapaian, sisaTarget],
                    chart: {
                        type: 'donut',
                        height: window.innerWidth < 640 ? 256 : 320,
                        animations: {
                            enabled: true,
                            easing: 'easeinout',
                            speed: 800
                        }
                    },
                    tooltip: {
                        enabled: false
                    }, // disable tooltip
                    states: {
                        hover: {
                            filter: {
                                type: 'none'
                            }
                        }, // disable hover effect
                        active: {
                            filter: {
                                type: 'none'
                            }
                        } // disable click highlight
                    },
                    markers: {
                        hover: {
                            size: 0
                        }
                    }, // prevent marker enlargement
                    labels: ['Capaian', 'Sisa Target'],
                    colors: ['#3b82f6', '#f87171'],
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    total: {
                                        show: true,
                                        label: 'Total Target',
                                        fontSize: window.innerWidth < 640 ? '12px' : '16px',
                                        formatter: function() {
                                            return totalTarget.toLocaleString();
                                        }
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: window.innerWidth >= 640,
                        style: {
                            fontSize: window.innerWidth < 640 ? '10px' : '12px'
                        },
                        formatter: function(val, opts) {
                            if (window.innerWidth < 640) {
                                return Math.round(val) + '%';
                            }
                            return opts.w.config.series[opts.seriesIndex].toLocaleString();
                        }
                    },
                    legend: {
                        position: 'bottom',
                        horizontalAlign: 'center',
                        fontSize: window.innerWidth < 640 ? '12px' : '14px'
                    },
                    noData: {
                        text: 'No data available'
                    }
                };

                targetChart = new ApexCharts(document.getElementById("target-chart"), targetOptions);
                targetChart.render();
            }
        });
    </script>

</body>

</html>
