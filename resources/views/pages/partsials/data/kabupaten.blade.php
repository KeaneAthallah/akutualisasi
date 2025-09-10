<!-- KABUPATEN TABLE -->
<h2 class="text-lg font-bold text-gray-700 mb-4">Data Kabupaten</h2>
<div class="flex gap-3 mb-3">
    <a href="{{ route('kabupatens.export') }}" class="mb-3 inline-block px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
        Export to Excel
    </a>
    <!-- Tambah Data Trigger -->
    <a href="#" data-modal-target="addKabupatenModal" data-modal-toggle="addKabupatenModal"
       class="mb-3 inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        + Tambah Data
    </a>
</div>

<div class="overflow-x-auto mb-10">
    <table class="w-full text-sm text-left text-gray-600 border border-gray-200">
        <thead class="text-xs uppercase bg-gray-100 text-gray-700">
            <tr>
                <th class="px-4 py-2">Nama Kabupaten</th>
                <th class="px-4 py-2 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kabupatens as $kabupaten)
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-4 py-2">{{ $kabupaten->name }}</td>
                    <td class="px-4 py-2 text-center">
                        <div class="flex justify-center gap-2">
                            <!-- Edit Trigger -->
                            <a href="#" data-modal-target="editKabupatenModal-{{ $kabupaten->id }}" data-modal-toggle="editKabupatenModal-{{ $kabupaten->id }}"
                               class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">
                                Edit
                            </a>

                            <!-- Delete Trigger -->
                            <a href="#" data-modal-target="deleteKabupatenModal-{{ $kabupaten->id }}" data-modal-toggle="deleteKabupatenModal-{{ $kabupaten->id }}"
                               class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">
                                Hapus
                            </a>
                        </div>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div id="editKabupatenModal-{{ $kabupaten->id }}" tabindex="-1" aria-hidden="true"
                     class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
                    <div class="relative bg-white rounded-lg shadow w-full max-w-md p-6">
                        <h3 class="text-lg font-bold mb-4">Edit Kabupaten</h3>
                        <form action="{{ route('kabupatens.update', $kabupaten) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Nama Kabupaten</label>
                                <input type="text" name="name" value="{{ $kabupaten->name }}"
                                       class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
                            </div>
                            <div class="flex justify-end gap-2">
                                <button data-modal-hide="editKabupatenModal-{{ $kabupaten->id }}" type="button"
                                        class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                                    Batal
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Delete Modal -->
                <div id="deleteKabupatenModal-{{ $kabupaten->id }}" tabindex="-1" aria-hidden="true"
                     class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
                    <div class="relative bg-white rounded-lg shadow w-full max-w-md p-6">
                        <h3 class="text-lg font-bold mb-4">Hapus Kabupaten</h3>
                        <p class="mb-4">Yakin ingin menghapus <strong>{{ $kabupaten->name }}</strong>?</p>
                        <form action="{{ route('kabupatens.destroy', $kabupaten) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="flex justify-end gap-2">
                                <button data-modal-hide="deleteKabupatenModal-{{ $kabupaten->id }}" type="button"
                                        class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                                    Batal
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                                    Hapus
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="2" class="px-4 py-2 text-center text-gray-500">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $kabupatens->links() }}

<!-- Add Modal -->
<div id="addKabupatenModal" tabindex="-1" aria-hidden="true"
     class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50">
    <div class="relative bg-white rounded-lg shadow w-full max-w-md p-6">
        <h3 class="text-lg font-bold mb-4">Tambah Kabupaten</h3>
        <form action="{{ route('kabupatens.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium mb-1">Nama Kabupaten</label>
                <input type="text" name="name"
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:ring focus:ring-blue-200" required>
            </div>
            <div class="flex justify-end gap-2">
                <button data-modal-hide="addKabupatenModal" type="button"
                        class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500">
                    Batal
                </button>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
