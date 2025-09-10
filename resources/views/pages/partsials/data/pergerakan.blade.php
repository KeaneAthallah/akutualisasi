<div class="container mx-auto px-4 py-6">
    <!-- Success/Error Messages -->
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            {{ session('error') }}
        </div>
    @endif

    <!-- PERGERAKAN KBPP TABLE -->
    <h2 class="text-lg font-bold text-gray-700 mt-10 mb-4">Data Pergerakan KBPP</h2>

    <div class="flex gap-3 mb-3">
        <button data-modal-target="addPergerakanKbppModal" data-modal-toggle="addPergerakanKbppModal"
            class="mb-3 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Tambah Data
        </button>
    </div>

    <div class="overflow-x-auto mb-10">
        <table class="w-full text-sm text-left text-gray-600 border border-gray-200">
            <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">Nama Kegiatan</th>
                    <th class="px-4 py-2">Waktu Pelaksanaan</th>
                    <th class="px-4 py-2">Tempat</th>
                    <th class="px-4 py-2">Link</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pergerakanKbpps as $pergerakanKbpp)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $pergerakanKbpp->nama_kegiatan }}</td>
                        <td class="px-4 py-2">{{ $pergerakanKbpp->formatted_waktu }}</td>
                        <td class="px-4 py-2">{{ $pergerakanKbpp->tempat }}</td>
                        <td class="px-4 py-2">
                            @if ($pergerakanKbpp->link)
                                <a href="{{ $pergerakanKbpp->link }}" target="_blank"
                                    class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                        </path>
                                    </svg>
                                    Link
                                </a>
                            @else
                                <span class="text-gray-400 text-xs">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center gap-2">
                                <button data-modal-target="editPergerakanKbppModal-{{ $pergerakanKbpp->id }}"
                                    data-modal-toggle="editPergerakanKbppModal-{{ $pergerakanKbpp->id }}"
                                    class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">
                                    Edit
                                </button>
                                <form action="{{ route('pergerakan-kbpp.destroy', $pergerakanKbpp->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data Pergerakan KBPP ini?')">
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
                    <div id="editPergerakanKbppModal-{{ $pergerakanKbpp->id }}" tabindex="-1" aria-hidden="true"
                        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                            <h3 class="text-lg font-semibold mb-4">Edit Pergerakan KBPP</h3>
                            <form action="{{ route('pergerakan-kbpp.update', $pergerakanKbpp->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Nama Kegiatan</label>
                                    <input type="text" name="nama_kegiatan"
                                        value="{{ $pergerakanKbpp->nama_kegiatan }}" required
                                        class="w-full border-gray-300 rounded-md">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Waktu Pelaksanaan</label>
                                    <input type="datetime-local" name="waktu_pelaksanaan"
                                        value="{{ $pergerakanKbpp->formatted_waktu_input }}" required
                                        class="w-full border-gray-300 rounded-md">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Tempat</label>
                                    <input type="text" name="tempat" value="{{ $pergerakanKbpp->tempat }}" required
                                        class="w-full border-gray-300 rounded-md">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Link</label>
                                    <input type="url" name="link" value="{{ $pergerakanKbpp->link }}"
                                        class="w-full border-gray-300 rounded-md" placeholder="https://example.com">
                                    <p class="text-xs text-gray-500">* Opsional</p>
                                </div>
                                <div class="flex justify-end gap-2">
                                    <button type="button"
                                        data-modal-hide="editPergerakanKbppModal-{{ $pergerakanKbpp->id }}"
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
                        <td colspan="5" class="px-4 py-2 text-center text-gray-500">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $pergerakanKbpps->links('pagination::tailwind') }}

    <!-- Add Modal -->
    <div id="addPergerakanKbppModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Tambah Pergerakan KBPP</h3>
            <form action="{{ route('pergerakan-kbpp.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium">Nama Kegiatan</label>
                    <input type="text" name="nama_kegiatan" required class="w-full border-gray-300 rounded-md">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium">Waktu Pelaksanaan</label>
                    <input type="datetime-local" name="waktu_pelaksanaan" required
                        class="w-full border-gray-300 rounded-md">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium">Tempat</label>
                    <input type="text" name="tempat" required class="w-full border-gray-300 rounded-md">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium">Link</label>
                    <input type="url" name="link" class="w-full border-gray-300 rounded-md"
                        placeholder="https://example.com">
                    <p class="text-xs text-gray-500">* Opsional</p>
                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" data-modal-hide="addPergerakanKbppModal"
                        class="px-4 py-2 bg-gray-300 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Include Flowbite JS for modal functionality -->
<script src="https://unpkg.com/flowbite@1.8.0/dist/flowbite.min.js"></script>
