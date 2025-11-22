<x-app-layout>

    <div class="max-w-6xl mx-auto px-4">
        <div class="page-container bg-white shadow-xl">

            <div class="pt-8 px-4 sm:px-6 mt-6 mb-6">

                {{-- bekne area kene ape ditambah background --}}
                {{-- <div style="background-color:aqua; padding-bottom: 1 rem;" class="px-5 pt-4 bg-cover bg-no-repeat "> background heading kursus --}}
                {{-- Bagian Mentor --}}
                <section class="mb-8">
                    <h2 class="text-lg font-bold text-gray-700 mb-2">Mentor Kelas ini:</h2>
                    <p class="text-sm text-gray-500 mb-4">Curriculum Mentor yang membangun kelas ini:</p>

                    {{-- Keterangan Mentor --}}
                    <div class="flex items-center space-x-3 py-2 px-3 rounded-full w-fit"
                        style="background-color:#578FCA">
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
                {{-- </div> --}}

                {{-- Daftar Pertemuan & Link Materi --}}
                <section class="mb-10">
                    <h3 class="text-base font-semibold text-gray-800 mb-3">Pilih materi:</h3>

                    <div id="daftar-kelas"></div>
                </section>

                {{-- Garis Pemisah --}}
                <div class="mb-6"></div>

                {{-- Tombol Lihat Hasil (Blok Hitam) --}}
                <div class="text-center mb-10">
                    <button
                        class="bg-black hover:bg-gray-900 text-white font-bold py-3 px-12 rounded-lg shadow-lg transition duration-200 w-full">
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
                    <div id="nilai-tambah"></div>
                </section>

                {{-- Tombol Unduh Sertifikat --}}
                <div class="text-center pb-8">
                    <a href="#" style="background-color: #578FCA"
                        class="inline-block hover:bg-yellow-500 text-gray-800 font-bold py-3 px-8 rounded-full shadow-xl transition duration-200 border-2 border-gray-400">
                        Unduh Sertifikat
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        // 1. Definisikan array data (versi JavaScript)
        const kelas = [{
                title: 'Pertemuan 1: Pengenalan Naratif Teknis',
                link: '#',
                status: 'finished'
            },
            {
                title: 'Pertemuan 2: Struktur Naratif Teknis',
                link: '#',
                status: 'ongoing'
            },
            {
                title: 'Pertemuan 3: Bahasa dan Gaya Penulisan',
                link: '#',
                status: 'unfinished'
            },
            {
                title: 'Pertemuan 4: Contoh Naratif Teknis',
                link: '#',
                status: 'unfinished'
            },
            {
                title: 'Pertemuan 5: Latihan Menulis Naratif Teknis',
                link: '#',
                status: 'unfinished'
            },
        ];

        // Dapatkan elemen kontainer dari DOM
        const container = document.getElementById('daftar-kelas');
        let htmlOutput = '';

        // 2. Iterasi array menggunakan forEach
        kelas.forEach(item => {
            let statusClass = '';
            let statusText = '';

            // 3. Logika pengondisian berdasarkan status
            if (item.status === 'finished') { // status selesai
                styl = "";
                statusClass = ' bg-blue-400 text-gray-500 border-gray-400';
                statusText = ' (Selesai)';
            } else { // status === 'unfinished'
                styl = "style=background-color:#578FCA; opacity:1";
                statusClass = 'bg-gray-200 hover:bg-gray-300 border-gray-400';
                statusText = ' (Belum Dimulai)';
            }

            htmlOutput += `
            <a href="${item.link}"
                ${styl}
                class="block font-semibold py-3 px-4 mb-3 rounded-lg shadow text-center text-sm border-2 border-black transition duration-200 ${statusClass}">
                ${item.title} ${statusText}
            </a>
        `;
        });

        container.innerHTML = htmlOutput;

        const nilaiTambahContainer = document.getElementById('nilai-tambah');
        const nilai_tambah_array = ["Absensi", "Essai", "Quiz"];
        let output_nilai_tambah = ""; // Initialize the output string

        // Use a for...of loop to iterate over the array values directly
        for (const item of nilai_tambah_array) {
            output_nilai_tambah += `
        <div class="w-full bg-gray-300 text-gray-800 font-semibold py-3 px-4 mb-3 rounded-lg shadow text-center text-sm border-2 border-black">
            ${item}
        </div>`;
        }

        nilaiTambahContainer.innerHTML = output_nilai_tambah;
    </script>
</x-app-layout>
