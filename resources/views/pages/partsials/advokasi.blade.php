<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Advokasi</title>
    <link rel="icon" type="image/png" href="{{ asset('./logo.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <div class="min-h-screen">
        <!-- Header -->
        <div class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="py-6 flex items-center justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Advokasi</h2>
                    <button onclick="history.back()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                        ← Back
                    </button>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <!-- Search -->
                <form method="GET" action="{{ route('advokasi') }}"
                    class="mb-6 flex flex-col md:flex-row gap-4 items-center bg-white p-4 rounded-lg shadow">
                    <input type="text" name="search" placeholder="Cari dokumen..." value="{{ $search ?? '' }}"
                        class="w-full md:w-1/2 rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Cari</button>
                </form>

                <!-- Grid Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse ($items as $item)
                        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow hover:shadow-lg transition">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $item->title }}</h3>
                            <p class="text-sm text-gray-600 mb-4">No Surat: {{ $item->no_surat }}</p>
                            <a href="{{ $item->file_path }}" target="_blank"
                                class="inline-block px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow hover:bg-blue-700 transition">
                                📄 Lihat Dokumen
                            </a>
                        </div>
                    @empty
                        <div class="col-span-full text-center text-gray-600">
                            Tidak ada data ditemukan.
                        </div>
                    @endforelse
                </div>

            </div>
        </div>
    </div>
</body>

</html>
