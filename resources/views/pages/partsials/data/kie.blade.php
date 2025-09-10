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

    <!-- KIE KBPP TABLE -->
    <h2 class="text-lg font-bold text-gray-700 mt-10 mb-4">Data KIE KBPP</h2>

    <div class="flex gap-3 mb-3">
        <button data-modal-target="addKieKbppModal" data-modal-toggle="addKieKbppModal"
            class="mb-3 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
            + Tambah Data
        </button>
    </div>

    <div class="overflow-x-auto mb-10">
        <table class="w-full text-sm text-left text-gray-600 border border-gray-200">
            <thead class="text-xs uppercase bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2">Judul</th>
                    <th class="px-4 py-2">Ringkasan Materi</th>
                    <th class="px-4 py-2">Link</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kieKbpps as $kieKbpp)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $kieKbpp->title }}</td>
                        <td class="px-4 py-2">
                            <div class="max-w-xs truncate">
                                {{ Str::limit($kieKbpp->ringkasan_materi, 100) }}
                            </div>
                        </td>
                        <td class="px-4 py-2">

                            <a href="{{ url($kieKbpp->file_name) }}"
                                class="inline-flex items-center px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                Link
                            </a>

                        </td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center gap-2">
                                <button data-modal-target="editKieKbppModal-{{ $kieKbpp->id }}"
                                    data-modal-toggle="editKieKbppModal-{{ $kieKbpp->id }}"
                                    class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">
                                    Edit
                                </button>
                                <form action="{{ route('kie-kbpp.destroy', $kieKbpp->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data KIE KBPP ini?')">
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
                    <div id="editKieKbppModal-{{ $kieKbpp->id }}" tabindex="-1" aria-hidden="true"
                        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                            <h3 class="text-lg font-semibold mb-4">Edit KIE KBPP</h3>
                            <form action="{{ route('kie-kbpp.update', $kieKbpp->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Judul</label>
                                    <input type="text" name="title" value="{{ $kieKbpp->title }}" required
                                        class="w-full border-gray-300 rounded-md">
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">Ringkasan Materi</label>
                                    <textarea name="ringkasan_materi" rows="4" required class="w-full border-gray-300 rounded-md">{{ $kieKbpp->ringkasan_materi }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="block text-sm font-medium">File</label>
                                    <input type="text" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                        class="w-full border-gray-300 rounded-md" value="{{ $kieKbpp->file_name }}">

                                </div>
                                <div class="flex justify-end gap-2">
                                    <button type="button" data-modal-hide="editKieKbppModal-{{ $kieKbpp->id }}"
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
                        <td colspan="4" class="px-4 py-2 text-center text-gray-500">Tidak ada data</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $kieKbpps->links('pagination::tailwind') }}

    <!-- Add Modal -->
    <div id="addKieKbppModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-semibold mb-4">Tambah KIE KBPP</h3>
            <form action="{{ route('kie-kbpp.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm font-medium">Judul</label>
                    <input type="text" name="title" required class="w-full border-gray-300 rounded-md">
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium">Ringkasan Materi</label>
                    <textarea name="ringkasan_materi" rows="4" required class="w-full border-gray-300 rounded-md"></textarea>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium">File</label>
                    <input type="text" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                        class="w-full border-gray-300 rounded-md">

                </div>
                <div class="flex justify-end gap-2">
                    <button type="button" data-modal-hide="addKieKbppModal"
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
