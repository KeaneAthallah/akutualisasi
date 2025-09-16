<!-- KECAMATAN TABLE -->
<h2 class="text-lg font-bold text-gray-700 mt-10 mb-4">Data Kecamatan</h2>

<a href="{{ route('kecamatans.export', request()->only('kabupaten_id_kec')) }}"
    class="mb-3 inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
    Export to Excel
</a>

<!-- Dropdown filter for kecamatan table -->
<form method="GET" action="{{ route('data-capaian-kbpp') }}" class="mb-4 flex gap-2">
    <div>
        <label for="kabupaten_id_kec" class="block text-sm font-medium text-gray-700">Filter Kabupaten</label>
        <select name="kabupaten_id_kec" id="kabupaten_id_kec" class="mt-1 block w-64 rounded-md border-gray-300 shadow-sm"
            onchange="this.form.submit()">
            <option value="">-- Semua Kabupaten --</option>
            @foreach ($allKabupatens as $kabupaten)
                <option value="{{ $kabupaten->id }}"
                    {{ $kabupatenFilterForKecamatan == $kabupaten->id ? 'selected' : '' }}>
                    {{ $kabupaten->name }}
                </option>
            @endforeach
        </select>
    </div>
</form>

<div class="flex gap-3 mb-3">
    <button data-modal-target="addKecamatanModal" data-modal-toggle="addKecamatanModal"
        class="mb-3 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        + Tambah Data
    </button>
</div>
<!-- Import Form -->
<form action="{{ route('kecamatans.import') }}" method="POST" enctype="multipart/form-data"
    class="mb-3 flex flex-col gap-2">
    @csrf

    <!-- Select Kabupaten -->
    <label class="font-semibold text-gray-700">Pilih Kabupaten:</label>
    <select name="kabupaten_id" class="border p-2 rounded" required>
        <option value="">-- Pilih Kabupaten --</option>
        @foreach ($kabupatens as $kabupaten)
            <option value="{{ $kabupaten->id }}">{{ $kabupaten->name }}</option>
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
                <th class="px-4 py-2">Tahun</th>
                <th class="px-4 py-2">Target KBPP</th>
                <th class="px-4 py-2">Capaian KBPP S/D 3 {{ $latest_month ?? '-' }}</th>
                <th class="px-4 py-2">Capaian KBPP S/D 3 {{ $latest_month ?? '-' }} (%)</th>
                <th class="px-4 py-2">Target KBPP MKJP</th>
                <th class="px-4 py-2">Capaian KBPP MKJP S/D 3 {{ $latest_month ?? '-' }}</th>
                <th class="px-4 py-2">Capaian KBPP MKJP S/D 3 {{ $latest_month ?? '-' }} (%)</th>
                <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kecamatans as $kecamatan)
                @php
                    $capaian_kbpp = $kecamatan->capaian_kbpp ?? 0;
                    $capaian_mkjp = $kecamatan->capaian_mkjp ?? 0;
                @endphp
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $kecamatan->kabupaten->name }}</td>
                    <td class="px-4 py-2">{{ $kecamatan->name }}</td>
                    <td class="px-4 py-2">{{ $kecamatan->year }}</td>
                    <td class="px-4 py-2">{{ $kecamatan->target_kbpp ?? 0 }}</td>
                    <td class="px-4 py-2">{{ $capaian_kbpp }}</td>
                    <td class="px-4 py-2">
                        @if ($kecamatan->target_kbpp > 0)
                            {{ number_format(($capaian_kbpp / $kecamatan->target_kbpp) * 100, 2) }}%
                        @else
                            0%
                        @endif
                    </td>
                    <td class="px-4 py-2">{{ $kecamatan->target_mkjp ?? 0 }}</td>
                    <td class="px-4 py-2">{{ $capaian_mkjp }}</td>
                    <td class="px-4 py-2">
                        @if ($kecamatan->target_mkjp > 0)
                            {{ number_format(($capaian_mkjp / $kecamatan->target_mkjp) * 100, 2) }}%
                        @else
                            0%
                        @endif
                    </td>
                    <td class="px-4 py-2 text-center">
                        <div class="flex justify-center gap-2">
                            <button data-modal-target="editKecamatanModal-{{ $kecamatan->id }}"
                                data-modal-toggle="editKecamatanModal-{{ $kecamatan->id }}"
                                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">
                                Edit
                            </button>
                            <form action="{{ route('kecamatans.destroy', $kecamatan->id) }}" method="POST"
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
                <div id="editKecamatanModal-{{ $kecamatan->id }}" tabindex="-1" aria-hidden="true"
                    class="hidden fixed inset-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                        <h3 class="text-lg font-semibold mb-4">Edit Kecamatan</h3>
                        <form action="{{ route('kecamatans.update', $kecamatan->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="kabupaten_id" class="block text-sm font-medium">Kabupaten</label>
                                <select name="kabupaten_id" class="w-full border-gray-300 rounded-md">
                                    @foreach ($allKabupatens as $kabupaten)
                                        <option value="{{ $kabupaten->id }}"
                                            {{ $kecamatan->kabupaten_id == $kabupaten->id ? 'selected' : '' }}>
                                            {{ $kabupaten->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Nama Kecamatan</label>
                                <input type="text" name="name" value="{{ $kecamatan->name }}"
                                    class="w-full border-gray-300 rounded-md">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Tahun</label>
                                <input type="number" name="year" value="{{ $kecamatan->year }}"
                                    class="w-full border-gray-300 rounded-md">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Target KBPP</label>
                                <input type="number" name="target_kbpp" value="{{ $kecamatan->target_kbpp }}"
                                    class="w-full border-gray-300 rounded-md">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Capaian KBPP</label>
                                <input type="number" name="capaian_kbpp" value="{{ $capaian_kbpp }}"
                                    class="w-full border-gray-300 rounded-md" disabled>
                                <p class="text-xs text-gray-500">* Otomatis dihitung dari progress bulanan</p>
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Target MKJP</label>
                                <input type="number" name="target_mkjp" value="{{ $kecamatan->target_mkjp }}"
                                    class="w-full border-gray-300 rounded-md">
                            </div>
                            <div class="mb-3">
                                <label class="block text-sm font-medium">Capaian MKJP</label>
                                <input type="number" name="capaian_mkjp" value="{{ $capaian_mkjp }}"
                                    class="w-full border-gray-300 rounded-md" disabled>
                                <p class="text-xs text-gray-500">* Otomatis dihitung dari progress bulanan</p>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" data-modal-hide="editKecamatanModal-{{ $kecamatan->id }}"
                                    class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="10" class="px-4 py-2 text-center text-gray-500">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $kecamatans->appends(['kabupaten_id_kec' => $kabupatenFilterForKecamatan])->links('pagination::tailwind') }}

<!-- Add Modal -->
<div id="addKecamatanModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h3 class="text-lg font-semibold mb-4">Tambah Kecamatan</h3>
        <form action="{{ route('kecamatans.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="kabupaten_id" class="block text-sm font-medium">Kabupaten</label>
                <select name="kabupaten_id" class="w-full border-gray-300 rounded-md">
                    @foreach ($allKabupatens as $kabupaten)
                        <option value="{{ $kabupaten->id }}">{{ $kabupaten->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Nama Kecamatan</label>
                <input type="text" name="name" class="w-full border-gray-300 rounded-md">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Tahun</label>
                <input type="number" name="year" class="w-full border-gray-300 rounded-md">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Target KBPP</label>
                <input type="number" name="target_kbpp" class="w-full border-gray-300 rounded-md">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium">Target MKJP</label>
                <input type="number" name="target_mkjp" class="w-full border-gray-300 rounded-md">
            </div>
            <div class="flex justify-end gap-2">
                <button type="button" data-modal-hide="addKecamatanModal"
                    class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
