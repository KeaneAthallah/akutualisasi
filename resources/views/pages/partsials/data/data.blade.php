<!-- MONTHLY PROGRESS TABLE -->
<h2 class="text-lg font-bold text-gray-700 mt-10 mb-4">Data Monthly Progress</h2>
<a href="{{ route('monthly-progress.export', request()->query()) }}"
    class="mb-3 inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
    Export to Excel
</a>

<!-- Filters -->
<form method="GET" action="{{ route('data-capaian-kbpp') }}" class="flex flex-wrap gap-4 mb-6">
    <div>
        <label for="kabupaten_id" class="block text-sm font-medium text-gray-700">Kabupaten</label>
        <select name="kabupaten_id" id="kabupaten_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            onchange="this.form.submit()">
            <option value="">-- Semua Kabupaten --</option>
            @foreach ($allKabupatens as $kabupaten)
                <option value="{{ $kabupaten->id }}" {{ request('kabupaten_id') == $kabupaten->id ? 'selected' : '' }}>
                    {{ $kabupaten->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div>
        <label for="kecamatan_id" class="block text-sm font-medium text-gray-700">Kecamatan</label>
        <select name="kecamatan_id" id="kecamatan_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            onchange="this.form.submit()">
            <option value="">-- Semua Kecamatan --</option>
            @foreach ($allKecamatans as $kecamatan)
                <option value="{{ $kecamatan->id }}" {{ request('kecamatan_id') == $kecamatan->id ? 'selected' : '' }}>
                    {{ $kecamatan->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="flex items-end">
        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            Cari
        </button>
    </div>
</form>

<div class="flex gap-3 mb-3">
    <!-- Button Tambah -->
    <button data-modal-target="addProgressModal" data-modal-toggle="addProgressModal"
        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        + Tambah Data
    </button>
</div>
<form action="{{ route('monthly-progress.import') }}" method="POST" enctype="multipart/form-data"
    class="mb-3 flex flex-col gap-2">
    @csrf

    <!-- Select Kecamatan -->
    <label class="font-semibold text-gray-700">Pilih Kecamatan:</label>
    <select name="kecamatan_id" class="border p-2 rounded" required>
        <option value="">-- Pilih Kecamatan --</option>
        @foreach ($kecamatans as $kecamatan)
            <option value="{{ $kecamatan->id }}">{{ $kecamatan->name }}</option>
        @endforeach
    </select>

    <!-- CSV File Upload -->
    <input type="file" name="file" accept=".csv" class="border p-2 rounded" required>

    <!-- Submit -->
    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        Import CSV
    </button>
</form>

<div class="overflow-x-auto mb-10">
    <table class="w-full text-sm text-left text-gray-600 border border-gray-200">
        <thead class="text-xs uppercase bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-2">Kabupaten</th>
                <th class="px-4 py-2">Kecamatan</th>
                <th class="px-4 py-2">Bulan</th>
                <th class="px-4 py-2">Tahun</th>
                <th class="px-4 py-2">Capaian KBPP</th>
                <th class="px-4 py-2">Capaian KBPP (%)</th>
                <th class="px-4 py-2">Capaian MKJP</th>
                <th class="px-4 py-2">Capaian MKJP (%)</th>
                <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($progress as $item)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $item->kecamatan->kabupaten->name }}</td>
                    <td class="px-4 py-2">{{ $item->kecamatan->name }}</td>
                    <td class="px-4 py-2">{{ $item->month }}</td>
                    <td class="px-4 py-2">{{ $item->kecamatan->year }}</td>
                    <td class="px-4 py-2">{{ $item->capaian_kbpp }}</td>
                    <td class="px-4 py-2">
                        {{ $item->kecamatan->target_kbpp > 0 ? round(($item->capaian_kbpp / $item->kecamatan->target_kbpp) * 100, 2) : 0 }}%
                    </td>
                    <td class="px-4 py-2">{{ $item->capaian_mkjp }}</td>
                    <td class="px-4 py-2">
                        {{ $item->kecamatan->target_mkjp > 0 ? round(($item->capaian_mkjp / $item->kecamatan->target_mkjp) * 100, 2) : 0 }}%
                    </td>
                    <td class="px-4 py-2 text-center">
                        <div class="flex justify-center gap-2">
                            <button data-modal-target="editProgressModal-{{ $item->id }}"
                                data-modal-toggle="editProgressModal-{{ $item->id }}"
                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">
                                Edit
                            </button>
                            <form action="{{ route('monthly-progress.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div id="editProgressModal-{{ $item->id }}" tabindex="-1" aria-hidden="true"
                    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg shadow p-6 w-full max-w-lg">
                        <h3 class="text-lg font-bold mb-4">Edit Monthly Progress</h3>
                        <form method="POST" action="{{ route('monthly-progress.update', $item->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label class="block text-sm font-medium">Kecamatan</label>
                                <select name="kecamatan_id" class="w-full border-gray-300 rounded">
                                    @foreach ($allKecamatans as $kec)
                                        <option value="{{ $kec->id }}"
                                            {{ $item->kecamatan_id == $kec->id ? 'selected' : '' }}>
                                            {{ $kec->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium">Bulan</label>
                                <select name="month" class="w-full border-gray-300 rounded" required>
                                    <option value="">-- Pilih Bulan --</option>
                                    @php
                                        $months = [
                                            'Januari',
                                            'Februari',
                                            'Maret',
                                            'April',
                                            'Mei',
                                            'Juni',
                                            'Juli',
                                            'Agustus',
                                            'September',
                                            'Oktober',
                                            'November',
                                            'Desember',
                                        ];
                                    @endphp
                                    @foreach ($months as $month)
                                        <option value="{{ $month }}"
                                            {{ $item->month == $month ? 'selected' : '' }}>
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="mb-4">
                                <label class="block text-sm font-medium">Capaian KBPP</label>
                                <input type="number" name="capaian_kbpp" value="{{ $item->capaian_kbpp }}"
                                    class="w-full border-gray-300 rounded">
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium">Capaian MKJP</label>
                                <input type="number" name="capaian_mkjp" value="{{ $item->capaian_mkjp }}"
                                    class="w-full border-gray-300 rounded">
                            </div>

                            <div class="flex justify-end gap-2">
                                <button type="button" data-modal-hide="editProgressModal-{{ $item->id }}"
                                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</button>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="9" class="px-4 py-2 text-center text-gray-500">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $progress->appends(request()->query())->links('pagination::tailwind') }}

<!-- Add Modal -->
<div id="addProgressModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white rounded-lg shadow p-6 w-full max-w-lg">
        <h3 class="text-lg font-bold mb-4">Tambah Monthly Progress</h3>
        <form method="POST" action="{{ route('monthly-progress.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium">Kecamatan</label>
                <select name="kecamatan_id" class="w-full border-gray-300 rounded">
                    @foreach ($allKecamatans as $kec)
                        <option value="{{ $kec->id }}">{{ $kec->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Bulan</label>
                <select name="month" class="w-full border-gray-300 rounded" required>
                    <option value="">-- Pilih Bulan --</option>
                    <option value="Januari">Januari</option>
                    <option value="Februari">Februari</option>
                    <option value="Maret">Maret</option>
                    <option value="April">April</option>
                    <option value="Mei">Mei</option>
                    <option value="Juni">Juni</option>
                    <option value="Juli">Juli</option>
                    <option value="Agustus">Agustus</option>
                    <option value="September">September</option>
                    <option value="Oktober">Oktober</option>
                    <option value="November">November</option>
                    <option value="Desember">Desember</option>
                </select>
            </div>


            <div class="mb-4">
                <label class="block text-sm font-medium">Capaian KBPP</label>
                <input type="number" name="capaian_kbpp" class="w-full border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Capaian MKJP</label>
                <input type="number" name="capaian_mkjp" class="w-full border-gray-300 rounded" required>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" data-modal-hide="addProgressModal"
                    class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</button>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Tambah</button>
            </div>
        </form>
    </div>
</div>
