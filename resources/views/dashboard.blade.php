<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- Filters -->
                <form method="GET" action="{{ route('dashboard') }}"
                      class="p-4 md:p-6 flex flex-col md:flex-row gap-4 md:gap-6 mb-6 bg-white rounded-lg shadow-sm">

                    <!-- Kabupaten -->
                    <div class="w-full md:w-64">
                        <label for="kabupaten_id" class="block text-sm font-medium text-gray-700">Kabupaten</label>
                        <select id="kabupaten_id" name="kabupaten_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Semua Kabupaten --</option>
                            @foreach($allKabupatens as $kabupaten)
                                <option value="{{ $kabupaten->id }}" {{ $kabupatenId == $kabupaten->id ? 'selected' : '' }}>
                                    {{ $kabupaten->name }}
                                </option>
                            @endforeach
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
                        <button type="submit"
                                class="w-full md:w-auto px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Filter
                        </button>
                    </div>
                </form>

                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 mb-6">
                    <div class="bg-gradient-to-r from-amber-400 to-orange-500 rounded-xl p-6 text-white shadow-lg">
                        <h3 class="text-lg font-semibold mb-2">JUMLAH CAPAIAN KBPP SAAT INI</h3>
                        <div class="text-4xl font-bold mb-1">{{ $totalCapaian }}</div>
                        <div class="text-2xl font-semibold">
                            {{ $totalTarget > 0 ? number_format(($totalCapaian / $totalTarget) * 100, 2) : 0 }}%
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-teal-400 to-cyan-500 rounded-xl p-6 text-white shadow-lg">
                        <h3 class="text-lg font-semibold mb-2">JUMLAH CAPAIAN MKJP SAAT INI</h3>
                        <div class="text-4xl font-bold mb-1">{{ $totalCapaianMkjp }}</div>
                        <div class="text-2xl font-semibold">
                            {{ $totalTargetMkjp > 0 ? number_format(($totalCapaianMkjp / $totalTargetMkjp) * 100, 2) : 0 }}%
                        </div>
                    </div>

                    <div class="bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl p-6 text-white shadow-lg">
                        <h3 class="text-lg font-semibold mb-2">STATUS TARGET</h3>
                        <div class="text-4xl font-bold mb-1">{{ $totalTarget }}</div>
                        <div class="text-lg">Total Target</div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">PENINGKATAN CAPAIAN KBPP</h3>
                        <div id="monthly-chart" class="h-80"></div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">TARGET vs. CAPAIAN KBPP</h3>
                        <div id="target-chart" class="h-80"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const kabupatenSelect = document.getElementById('kabupaten_id');
            const kecamatanSelect = document.getElementById('kecamatan_id');

            // Load kecamatan dynamically
            function loadKecamatan(kabupatenId, selectedId = null) {
                kecamatanSelect.innerHTML = '<option value="">-- Semua Kecamatan --</option>';
                if (kabupatenId) {
                    fetch(`/get-kecamatan/${kabupatenId}`)
                        .then(res => res.json())
                        .then(data => {
                            data.forEach(k => {
                                const opt = document.createElement('option');
                                opt.value = k.id;
                                opt.textContent = k.name;
                                if (selectedId && selectedId == k.id) opt.selected = true;
                                kecamatanSelect.appendChild(opt);
                            });
                        });
                }
            }

            if (kabupatenSelect.value) {
                loadKecamatan(kabupatenSelect.value, "{{ $kecamatanId }}");
            }

            kabupatenSelect.addEventListener('change', function() {
                loadKecamatan(this.value);
            });

            // Charts
            const monthlyData = @json(array_values($monthlyData));
            const monthlyCategories = @json(array_keys($monthlyData));

            const monthlyOptions = {
                series: [{ name: "Capaian KBPP", data: monthlyData, color: "#e74c3c" }],
                chart: { type: "bar", height: 320, toolbar: { show: false } },
                xaxis: { categories: monthlyCategories },
                dataLabels: { enabled: true }
            };
            new ApexCharts(document.getElementById("monthly-chart"), monthlyOptions).render();

            const targetOptions = {
                series: [{{ $totalCapaian }}, {{ $totalTarget - $totalCapaian }}],
                chart: { type: 'donut', height: 320 },
                labels: ['Capaian', 'Sisa Target'],
                colors: ['#3b82f6', '#f87171']
            };
            new ApexCharts(document.getElementById("target-chart"), targetOptions).render();
        });
    </script>
    @endpush
</x-app-layout>
