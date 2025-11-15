<x-app-layout>
    <div class="mx-auto max-w-6xl px-4 py-10">
        <style>
            /* Custom kecil untuk konsistensi */
            .accent {
                background: linear-gradient(90deg, #f59e0b, #fbbf24);
            }

            .card-shadow {
                box-shadow: 0 6px 18px rgba(15, 23, 42, 0.06);
            }

            .muted {
                color: #6b7280;
            }

            .compact p {
                margin-bottom: .4rem;
                line-height: 1.25;
            }

            /* tampilkan gambar 10% dari ukuran kontainer (1/10) */
            .img-10pct {
                width: 10% !important;
                height: auto !important;
                max-width: none !important;
                display: inline-block;
            }

            /* fallback untuk layar sangat kecil agar tidak terlalu kecil */
            @media (max-width: 480px) {
                .img-10pct {
                    width: 48px !important;
                }
            }
        </style>

        <!-- Materi & Tujuan (seluruh teks dari gambar ke-2 dimasukkan di sini) -->
        <section class="mt-6">

        </section>

        <!-- HERO (gambar di sebelah kanan pada layar md+) -->
        <section class="card-shadow grid grid-cols-1 items-center gap-6 rounded-lg bg-white p-6 md:grid-cols-2 md:p-10">
            <div class="card-shadow rounded-lg bg-white p-6">
                <div class="mb-3 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="text-lg font-bold text-yellow-500">⭐</div>
                        <div>
                            <div class="muted text-sm">Materi</div>
                            <div class="text-lg font-semibold">4.89</div>
                        </div>
                    </div>
                </div>

                <h2 class="mb-3 text-2xl font-bold">Naratif Teknis</h2>

                <p class="mb-3 text-gray-700">
                    Naratif teknis adalah teks atau penulisan berbentuk narasi (cerita) yang digunakan untuk menjelaskan proses, prosedur, atau teknologi secara sistematis.
                </p>

                <h3 class="mb-2 text-lg font-semibold">Tujuan Naratif Teknis</h3>
                <ol class="list-decimal space-y-1 pl-5 text-sm text-gray-700">
                    <li>Menjelaskan cara kerja sesuatu — misalnya mesin, sistem, aplikasi, atau alat.</li>
                    <li>Memberikan panduan atau prosedur penggunaan.</li>
                    <li>Menceritakan proses pengembangan teknologi secara kronologis.</li>
                    <li>Memberi pemahaman teknis kepada pembaca non-teknis dengan bahasa naratif yang mudah diikuti.</li>
                </ol>
            </div>
            <div class="order-2 w-full md:order-2">
                <img src="{{ asset('asset/family.jpeg') }}" alt="Ilustrasi kursus" class="h-64 w-full rounded-lg object-cover md:h-56 lg:h-72">
            </div>
        </section>

        <!-- DETAILS + SIDEBAR -->
        <section class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
            <article class="card-shadow compact rounded-lg bg-white p-6 lg:col-span-2">
                <h3 class="mb-3 text-xl font-bold">Deskripsi Lengkap</h3>
                <p class="mb-4 text-gray-700">
                    Kelas ini dirancang untuk membantu Anda menguasai keterampilan menulis teknis yang dibutuhkan di berbagai industri.
                    Mulai dari perencanaan, penulisan, hingga revisi akhir, setiap modul berisi latihan praktis dan contoh nyata.
                </p>

                <div class="mt-4 grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <h4 class="mb-2 font-semibold">Apa yang akan dipelajari</h4>
                        <ul class="muted list-disc space-y-1 pl-5 text-sm">
                            <li>Menulis dengan jelas dan ringkas</li>
                            <li>Menyusun informasi secara logis</li>
                            <li>Menggunakan gaya bahasa sesuai audiens</li>
                            <li>Membuat manual, laporan, dan panduan</li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="mb-2 font-semibold">Siapa yang cocok</h4>
                        <ul class="muted list-disc space-y-1 pl-5 text-sm">
                            <li>Mahasiswa dan profesional</li>
                            <li>Penulis konten yang ingin memperluas keahlian</li>
                            <li>Siapa saja yang tertarik komunikasi teknis</li>
                        </ul>
                    </div>
                </div>

                <div class="mt-6">
                    <h4 class="mb-2 font-semibold">Instruktur</h4>
                    <div class="flex items-center gap-4">
                        <img src="{{ asset('asset/cowboy.jpeg') }}" alt="Instruktur" class="h-16 w-16 rounded-full object-cover">
                        <div>
                            <div class="font-semibold">Gregorius Kasa</div>
                            <div class="muted text-sm">Penulis teknis berpengalaman, praktisi industri</div>
                        </div>
                    </div>
                </div>
            </article>

            <aside class="card-shadow rounded-lg bg-white p-6">
                <div class="mb-4">
                    <div class="muted text-sm">Harga</div>
                    <div class="text-2xl font-bold">Rp 350.000</div>
                </div>

                <div class="mb-4">
                    <div class="muted text-sm">Durasi</div>
                    <div class="font-semibold">16 Minggu</div>
                </div>

                <div class="mb-4">
                    <div class="muted text-sm">Level</div>
                    <div class="font-semibold">Pemula - Menengah</div>
                </div>

                <a href="#" class="accent mt-3 block rounded-lg px-4 py-3 text-center font-semibold text-black shadow transition hover:shadow-md">Daftar Sekarang</a>

                <div class="muted mt-6 text-sm">
                    <div class="mb-2 font-semibold">Fitur Tambahan</div>
                    <ul class="list-disc space-y-1 pl-5">
                        <li>Akses forum diskusi</li>
                        <li>Feedback mentor</li>
                        <li>Materi downloadable</li>
                    </ul>
                </div>
            </aside>
        </section>

        <!-- MENTOR -->
        <section class="card-shadow mt-8 rounded-lg bg-white p-6">
            <h3 class="mb-3 text-xl font-bold">Mentor Kelas</h3>
            <div class="flex items-start gap-4">
                <img src="{{ asset('asset/cowboy.jpeg') }}" alt="Mentor" class="img-10pct rounded-lg object-cover" loading="lazy">
                <div>
                    <div class="font-semibold">Gregorius Kasa</div>
                    <p class="muted mt-1 text-sm">Gregorius adalah penulis teknis berpengalaman dengan latar belakang teknik dan komunikasi. Ia membimbing peserta melalui contoh nyata dan tugas praktik.</p>
                </div>
            </div>
        </section>

        <!-- TESTIMONI -->
        <section class="mt-8">
            <h3 class="mb-4 text-xl font-bold">Testimoni Siswa</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="card-shadow rounded-lg bg-yellow-50 p-5">
                    <p class="italic text-gray-700">"Kelas ini membantu saya menyusun laporan teknis dengan lebih profesional."</p>
                    <div class="muted mt-3 text-sm">— Alumni, Universitas X</div>
                </div>

                <div class="card-shadow rounded-lg bg-yellow-50 p-5">
                    <p class="italic text-gray-700">"Instruktur sangat jelas menjelaskan konsep dan memberikan contoh nyata."</p>
                    <div class="muted mt-3 text-sm">— Alumni, Perusahaan Y</div>
                </div>
            </div>
        </section>


    </div>
</x-app-layout>
