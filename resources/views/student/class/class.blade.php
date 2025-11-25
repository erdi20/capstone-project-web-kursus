<x-app-layout>

    <div class="max-w-6xl mx-auto px-4">
        <div class="page-container bg-white shadow-xl">

            <div class="pt-8 px-4 sm:px-6 mt-6 mb-6">
                {{-- Bagian Mentor --}}
                <section class="mb-8">
                    <h2 class="text-lg font-bold text-gray-700 mb-2">Mentor Kelas ini:</h2>
                    <p class="text-sm text-gray-500 mb-4">Curriculum Mentor yang membangun kelas ini:</p>

                    {{-- Keterangan Mentor --}}
                    <div class="flex items-center space-x-3 py-2 px-3 rounded-full w-fit bg-gradient-to-r from-[#20C896] to-[#259D7A]">
                        {{-- Lingkaran Abu-abu (Gambar Mentor) --}}
                        <img alt="Mentor Kelas" src="{{ asset('storage/image/20241211_085802.jpg') }}"
                            class="h-8 w-8 bg-gray-300 rounded-full flex-shrink-0" />

                        {{-- Detail Mentor --}}
                        <div>
                            <p class="font-semibold text-l text-gray-900">Gilang Ramadhan</p>
                            <p class="text-xs text-gray-600">Program Manager at Dicoding</p>
                        </div>
                    </div>
                </section>

                {{-- Deskripsi Singkat Kursus --}}
                <section class="mb-10">
                    <h1 class="text-lg font-bold  text-gray-900 mb-3" style="text-size: unset">Naratif Teknis</h1>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Naratif teknis adalah teks atau penulisan berbentuk narasi (cerita) yang digunakan untuk
                        menjelaskan
                        proses, prosedur, atau teknologi secara sistematis. Naratif teknis adalah teks atau penulisan
                        berbentuk narasi (cerita) yang digunakan untuk menjelaskan proses, prosedur, atau teknologi
                        secara
                        sistematis.
                    </p>
                </section>

                {{-- Daftar Pertemuan & Link Materi --}}
                <section class="mb-10">
                    <h3 class="text-base font-semibold text-gray-800 mb-3">Pilih materi:</h3>

                    <div id="daftar-kelas">

                        <a href="#" 
                            class="block font-semibold py-3 px-4 mb-3 rounded-lg shadow text-center text-sm border-2 border-black transition duration-200 bg-gray-200 bg-gradient-to-r from-[#20C896] to-[#259D7A] hover:bg-green-900">
                            Pertemuan 1: Pengenalan Naratif Teknis
                        </a>

                        <a href="#" 
                            class="block font-semibold py-3 px-4 mb-3 rounded-lg shadow text-center text-sm border-2 border-black transition duration-200 bg-gray-200 bg-gradient-to-r from-[#20C896] to-[#259D7A] hover:bg-green-900">
                            Pertemuan 2: Struktur Naratif Teknis
                        </a>

                        <a href="#" 
                            class="block font-semibold py-3 px-4 mb-3 rounded-lg shadow text-center text-sm border-2 border-black transition duration-200 bg-gray-200 bg-gradient-to-r from-[#20C896] to-[#259D7A] hover:bg-green-900">
                            Pertemuan 3: Bahasa dan Gaya Penulisan
                        </a>

                        <a href="#" 
                            class="block font-semibold py-3 px-4 mb-3 rounded-lg shadow text-center text-sm border-2 border-black transition duration-200 bg-gray-200 bg-gradient-to-r from-[#20C896] to-[#259D7A] hover:bg-green-900">
                            Pertemuan 4: Contoh Naratif Teknis
                        </a>

                        <a href="#" 
                            class="block font-semibold py-3 px-4 mb-3 rounded-lg shadow text-center text-sm border-2 border-black transition duration-200 bg-gray-200 bg-gradient-to-r from-[#20C896] to-[#259D7A] hover:bg-green-900">
                            Pertemuan 5: Latihan Menulis Naratif Teknis
                        </a>
                    </div>
                </section>

                {{-- Garis Pemisah --}}
                <div class="mb-6"></div>

                {{-- Tombol Lihat Hasil (Blok Hitam) --}}
                <div class="text-center mb-10">
                    <button
                        class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-3 px-12 rounded-lg shadow-lg transition duration-200 w-full">
                        Lihat hasil
                    </button>
                </div>

                {{-- Garis Pemisah --}}
                <div class=" mt-2 mb-12 border-b-2 border-black" style="height: 2%"></div>

                {{-- Keterangan dan Link Aksi --}}
                <section class="mb-10"
                    style="max-width: 70%; align items: center; margin-left: auto; margin-right: auto;">
                    <p class="text-xs italic text-gray-600 mb-6">
                        *Ini sudah termasuk Test semua, seperti Quiz, Essai, dan Absensi.
                    </p>

                    {{-- Absensi, Essai, Quiz --}}
                    <div id="nilai-tambah">
                        <div class="w-full bg-gray-300 text-gray-800 font-semibold py-3 px-4 mb-3 rounded-lg shadow text-center text-sm border-2 border-black grid grid-cols-2 justify-items-center">
                            <div class=" text-left">Presensi</div>
                            <div class="text-right">5X</div>
                        </div>
                        <div class="w-full bg-gray-300 text-gray-800 font-semibold py-3 px-4 mb-3 rounded-lg shadow text-center text-sm border-2 border-black grid grid-cols-2 justify-items-center">
                            <div class=" text-left">Essai</div>
                            <div class="text-right">5X</div>
                        </div>
                        <div class="w-full bg-gray-300 text-gray-800 font-semibold py-3 px- mb-3 rounded-lg shadow text-center text-sm border-2 border-black grid grid-cols-2 justify-items-center">
                            <div class=" text-left">Quiz</div>
                            <div class="text-right">5X</div>
                        </div>
                    </div>
                </section>

                {{-- Tombol Unduh Sertifikat --}}
                <div class="text-center pb-8">
                    <a href="#" class="inline-block  text-gray-800 font-bold py-3 px-8 rounded-full shadow-xl transition duration-200 border-2 border-gray-400 hover:bg-green-900 bg-gradient-to-r from-[#20C896] to-[#259D7A] ">
                        Unduh Sertifikat
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
