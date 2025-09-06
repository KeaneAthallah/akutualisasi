<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BKKBN - Badan Kependudukan dan Keluarga Berencana Nasional</title>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
    <!-- Navigation Section -->
    <header class="w-full bg-white shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end py-4">
                <nav class="flex items-center justify-end gap-4">
                    @if (Route::has('login'))
                    @auth
                    <a href="{{ url('/dashboard') }}" class="inline-block px-5 py-1.5 text-gray-700 border border-transparent hover:border-gray-200 rounded-sm text-sm leading-normal transition-colors">
                        Dashboard
                    </a>
                    @else
                    <a href="{{ route('login') }}" class="inline-block px-5 py-1.5 text-gray-700 border border-transparent hover:border-gray-200 rounded-sm text-sm leading-normal transition-colors">
                        Masuk
                    </a>
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="inline-block px-5 py-1.5 text-gray-700 border border-transparent hover:border-gray-200 rounded-sm text-sm leading-normal transition-colors">
                        Daftar
                    </a>
                    @endif
                    @endauth
                    @endif
                </nav>
            </div>
        </div>
    </header>

    <main class="min-h-screen bg-gradient-to-br from-blue-50 to-green-50 flex flex-col items-center justify-start">
        <!-- Logo and Title Section -->
        <div class="w-full flex items-center justify-center py-12 px-6">
            <div class="text-center bg-white rounded-3xl p-8 shadow-xl border-2 border-gray-100 max-w-4xl w-full">
                <section>
                    <div class="px-4 sm:px-6 lg:px-8">
                        <div class="flex justify-center mb-8">
                            <div class="w-48 h-48 rounded-full flex items-center justify-center">
                                <img src="./logo.svg"/>
                            </div>
                        </div>

                        <h1 class="text-2xl md:text-4xl font-bold text-gray-800 mb-6 leading-tight">
                            Kementerian Kependudukan dan Pembangunan Keluarga/BKKBN<br>
                            Perwakilan BKKBN Provinsi Sulawesi Tengah
                        </h1>
                        <h2 class="text-xl md:text-2xl text-gray-600 mb-8 font-medium">
                            WADAH INTEGRASI KBPP<br>
                            SULAWESI TENGAH
                        </h2>
                        <p class="text-lg md:text-xl text-gray-700 max-w-2xl mx-auto leading-relaxed">
                            Selamat Datang di Wadah Integrasi KB Pascapersalinan (KBPP) Sulawesi Tengah 👋
                            <br><br>
                            Platform digital ini hadir untuk mendukung peningkatan pelayanan KB Pascapersalinan melalui akses data dan informasi terkini.
                            <br><br>
                            Bersama, kita wujudkan keluarga sehat dan sejahtera di Sulawesi Tengah.
                        </p>
                    </div>
                </section>
            </div>
        </div>

        <!-- Main Buttons Section -->
        <section class="py-8 w-full">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                    <!-- Service 1: Data Capaian KBPP -->
                    <div class="cursor-pointer transform transition-all duration-200 hover:scale-105 service-card"
                         data-service="kb">
                        <div class="bg-white rounded-3xl p-8 shadow-xl h-full border-2 border-gray-100 hover:border-blue-300 hover:shadow-2xl">
                            <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white mb-6 mx-auto">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>

                            <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                                Data Capaian KBPP
                            </h3>

                            <p class="text-gray-600 leading-relaxed text-center text-lg mb-6">
                                Lihat data dan statistik capaian program KB Pascapersalinan di Sulawesi Tengah
                            </p>

                            <div class="text-center">
                                <div class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-2xl text-lg shadow-lg hover:shadow-xl transition-all duration-200">
                                    <span>PILIH LAYANAN INI</span>
                                </div>
                            </div>

                            <div class="service-info mt-8 p-6 bg-blue-50 rounded-2xl border-2 border-blue-200 hidden">
                                <div class="text-center">
                                    <h4 class="text-xl font-bold text-blue-800 mb-4">
                                        Informasi Layanan
                                    </h4>
                                    <p class="text-blue-700 text-lg leading-relaxed mb-6">
                                        Akses data capaian program KB Pascapersalinan, laporan statistik, dan perkembangan terkini program KBPP di wilayah Sulawesi Tengah.
                                    </p>
                                    <a href="#" class="inline-flex items-center justify-center px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl text-lg shadow-lg hover:bg-blue-700 transition-colors">
                                        LANJUTKAN
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Service 2: Advokasi KBPP -->
                    <div class="cursor-pointer transform transition-all duration-200 hover:scale-105 service-card"
                         data-service="kia">
                        <div class="bg-white rounded-3xl p-8 shadow-xl h-full border-2 border-gray-100 hover:border-pink-300 hover:shadow-2xl">
                            <div class="w-20 h-20 bg-gradient-to-r from-pink-500 to-rose-500 rounded-2xl flex items-center justify-center text-white mb-6 mx-auto">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/>
                                </svg>
                            </div>

                            <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                                Advokasi KBPP
                            </h3>

                            <p class="text-gray-600 leading-relaxed text-center text-lg mb-6">
                                Program advokasi dan sosialisasi KB Pascapersalinan untuk meningkatkan kesadaran masyarakat
                            </p>

                            <div class="text-center">
                                <div class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-pink-500 to-rose-500 text-white font-bold rounded-2xl text-lg shadow-lg hover:shadow-xl transition-all duration-200">
                                    <span>PILIH LAYANAN INI</span>
                                </div>
                            </div>

                            <div class="service-info mt-8 p-6 bg-pink-50 rounded-2xl border-2 border-pink-200 hidden">
                                <div class="text-center">
                                    <h4 class="text-xl font-bold text-pink-800 mb-4">
                                        Informasi Layanan
                                    </h4>
                                    <p class="text-pink-700 text-lg leading-relaxed mb-6">
                                        Program advokasi kepada para pengambil kebijakan dan stakeholder untuk mendukung implementasi KBPP yang efektif dan berkelanjutan.
                                    </p>
                                    <a href="#" class="inline-flex items-center justify-center px-8 py-4 bg-pink-600 text-white font-bold rounded-2xl text-lg shadow-lg hover:bg-pink-700 transition-colors">
                                        LANJUTKAN
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Service 3: KIE KBPP -->
                    <div class="cursor-pointer transform transition-all duration-200 hover:scale-105 service-card"
                         data-service="konseling">
                        <div class="bg-white rounded-3xl p-8 shadow-xl h-full border-2 border-gray-100 hover:border-green-300 hover:shadow-2xl">
                            <div class="w-20 h-20 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center text-white mb-6 mx-auto">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>

                            <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                                KIE KBPP
                            </h3>

                            <p class="text-gray-600 leading-relaxed text-center text-lg mb-6">
                                Komunikasi, Informasi, dan Edukasi tentang KB Pascapersalinan untuk masyarakat
                            </p>

                            <div class="text-center">
                                <div class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-500 to-emerald-500 text-white font-bold rounded-2xl text-lg shadow-lg hover:shadow-xl transition-all duration-200">
                                    <span>PILIH LAYANAN INI</span>
                                </div>
                            </div>

                            <div class="service-info mt-8 p-6 bg-green-50 rounded-2xl border-2 border-green-200 hidden">
                                <div class="text-center">
                                    <h4 class="text-xl font-bold text-green-800 mb-4">
                                        Informasi Layanan
                                    </h4>
                                    <p class="text-green-700 text-lg leading-relaxed mb-6">
                                        Program KIE (Komunikasi, Informasi, Edukasi) untuk memberikan pemahaman yang benar tentang KB Pascapersalinan kepada masyarakat luas.
                                    </p>
                                    <a href="#" class="inline-flex items-center justify-center px-8 py-4 bg-green-600 text-white font-bold rounded-2xl text-lg shadow-lg hover:bg-green-700 transition-colors">
                                        LANJUTKAN
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Service 4: Pergerakan KBPP -->
                    <div class="cursor-pointer transform transition-all duration-200 hover:scale-105 service-card"
                         data-service="penyuluhan">
                        <div class="bg-white rounded-3xl p-8 shadow-xl h-full border-2 border-gray-100 hover:border-purple-300 hover:shadow-2xl">
                            <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-indigo-500 rounded-2xl flex items-center justify-center text-white mb-6 mx-auto">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>

                            <h3 class="text-2xl font-bold text-gray-800 mb-4 text-center">
                                Pergerakan KBPP
                            </h3>

                            <p class="text-gray-600 leading-relaxed text-center text-lg mb-6">
                                Gerakan dan mobilisasi masyarakat untuk mendukung program KB Pascapersalinan
                            </p>

                            <div class="text-center">
                                <div class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-purple-500 to-indigo-500 text-white font-bold rounded-2xl text-lg shadow-lg hover:shadow-xl transition-all duration-200">
                                    <span>PILIH LAYANAN INI</span>
                                </div>
                            </div>

                            <div class="service-info mt-8 p-6 bg-purple-50 rounded-2xl border-2 border-purple-200 hidden">
                                <div class="text-center">
                                    <h4 class="text-xl font-bold text-purple-800 mb-4">
                                        Informasi Layanan
                                    </h4>
                                    <p class="text-purple-700 text-lg leading-relaxed mb-6">
                                        Gerakan partisipatif masyarakat dalam mendukung dan mengimplementasikan program KB Pascapersalinan di tingkat komunitas.
                                    </p>
                                    <a href="#" class="inline-flex items-center justify-center px-8 py-4 bg-purple-600 text-white font-bold rounded-2xl text-lg shadow-lg hover:bg-purple-700 transition-colors">
                                        LANJUTKAN
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Info Section -->
        <section class="py-12 bg-white mt-12 w-full">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">
                    Butuh Bantuan?
                </h3>
                <div class="space-y-4 text-lg text-gray-700">
                    <p>
                        <span class="font-semibold">Telepon:</span> (021) 5211052
                    </p>
                    <p>
                        <span class="font-semibold">Email:</span> info@bkkbn.go.id
                    </p>
                    <p>
                        <span class="font-semibold">Website:</span>
                        <a href="https://www.bkkbn.go.id" class="text-blue-600 hover:text-blue-800">
                            www.bkkbn.go.id
                        </a>
                    </p>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const serviceCards = document.querySelectorAll('.service-card');
            let activeService = '';

            serviceCards.forEach(card => {
                card.addEventListener('click', function() {
                    const serviceId = this.dataset.service;
                    const serviceInfo = this.querySelector('.service-info');

                    // Hide all other service info panels
                    serviceCards.forEach(otherCard => {
                        if (otherCard !== this) {
                            otherCard.querySelector('.service-info').classList.add('hidden');
                        }
                    });

                    // Toggle current service info
                    if (activeService === serviceId) {
                        serviceInfo.classList.add('hidden');
                        activeService = '';
                    } else {
                        serviceInfo.classList.remove('hidden');
                        activeService = serviceId;
                    }
                });
            });
        });
    </script>
</body>
</html>
