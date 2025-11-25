<x-app-layout>
    <div class="mx-auto max-w-6xl px-4 py-10">
        <section class="grid grid-cols-1 items-center gap-6 rounded-lg bg-white p-6 shadow-sm md:grid-cols-2 md:p-10">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h2 class="mb-3 text-2xl font-bold">{{ $course->name }}</h2>
                <div class="prose prose-sm sm:prose-base max-w-none text-gray-700">
                    {!! $course->short_description !!}
                </div>
            </div>
            <div class="order-2 w-full md:order-2">
                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="Ilustrasi kursus" class="h-64 w-full rounded-lg object-cover md:h-56 lg:h-72">
            </div>
        </section>

        <section class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
            <article class="rounded-lg bg-white p-6 shadow-sm lg:col-span-2">
                <h3 class="mb-3 text-xl font-bold">Deskripsi Lengkap</h3>
                <div class="prose max-w-none text-gray-700">
                    {!! $course->description !!}
                </div>
            </article>

            <aside class="rounded-lg bg-white p-6 shadow-sm">
                <div class="mb-4">
                    <div class="text-sm text-gray-500">Harga</div>
                    @php
                        $isDiscountActive = $course->discount_price !== null && ($course->discount_end_date === null || now()->lessThan($course->discount_end_date));
                    @endphp

                    @if ($isDiscountActive)
                        <p class="text-sm text-gray-400 line-through">
                            Rp {{ number_format($course->price, 0, ',', '.') }}
                        </p>
                        <p class="text-lg font-bold text-gray-900">
                            Rp {{ number_format($course->discount_price, 0, ',', '.') }}
                        </p>
                    @else
                        <p class="text-lg font-bold text-gray-900">
                            Rp {{ number_format($course->price, 0, ',', '.') }}
                        </p>
                    @endif
                </div>

                <div class="mb-4">
                    <div class="text-sm text-gray-500">Durasi</div>
                    <div class="font-semibold">16 Minggu</div>
                </div>

                <div class="mb-4">
                    <div class="text-sm text-gray-500">Level</div>
                    <div class="font-semibold">Pemula - Menengah</div>
                </div>

                <a href="#" class="inline-block w-full rounded-lg bg-gradient-to-r from-amber-400 to-amber-300 px-4 py-3 text-center font-semibold text-black shadow transition hover:shadow-md">
                    Daftar Sekarang
                </a>

                <div class="mt-6 text-sm text-gray-500">
                    <div class="mb-2 font-semibold">Fitur Tambahan</div>
                    <ul class="list-disc space-y-1 pl-5">
                        <li>Akses forum diskusi</li>
                        <li>Feedback mentor</li>
                        <li>Materi downloadable</li>
                    </ul>
                </div>
            </aside>
        </section>

        <section class="mt-8 rounded-lg bg-white p-6 shadow-sm">
            <h3 class="mb-3 text-xl font-bold">Mentor Kelas</h3>
            <div class="flex items-start gap-4">
                <img src="{{ asset('storage/' . $course->user->avatar_url) }}" alt="Mentor" class="h-12 w-12 rounded-lg object-cover sm:h-16 sm:w-16" loading="lazy">
                <div>
                    <div class="font-semibold">{{ $course->user->name }}</div>
                    <p class="mt-1 text-sm text-gray-500">Gregorius adalah penulis teknis berpengalaman dengan latar belakang teknik dan komunikasi. Ia membimbing peserta melalui contoh nyata dan tugas praktik.</p>
                </div>
            </div>
        </section>

        <section class="mt-8">
            <h3 class="mb-4 text-xl font-bold">Testimoni Siswa</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="rounded-lg bg-amber-50 p-5 shadow-sm">
                    <p class="italic text-gray-700">"Kelas ini membantu saya menyusun laporan teknis dengan lebih profesional."</p>
                    <div class="mt-3 text-sm text-gray-500">— Alumni, Universitas X</div>
                </div>

                <div class="rounded-lg bg-amber-50 p-5 shadow-sm">
                    <p class="italic text-gray-700">"Instruktur sangat jelas menjelaskan konsep dan memberikan contoh nyata."</p>
                    <div class="mt-3 text-sm text-gray-500">— Alumni, Perusahaan Y</div>
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
