<x-app-layout>
    @if ($errors->any())
        <div class="mx-auto mb-4 max-w-6xl rounded-lg border border-red-400 bg-red-100 px-4 py-3 text-red-700">
            <strong class="font-bold">Gagal Mendaftar!</strong>
            <ul class="mt-1 list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('error'))
        <div class="mx-auto mb-4 max-w-6xl rounded-lg border border-yellow-400 bg-yellow-100 px-4 py-3 text-yellow-700">
            {{ session('error') }}
        </div>
    @endif
    <div class="mx-auto max-w-6xl px-4 py-10">
        <section class="grid grid-cols-1 items-center gap-6 rounded-lg bg-white p-6 shadow-sm md:grid-cols-2 md:p-10">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h2 class="mb-3 text-2xl font-bold">{{ $course->name }}</h2>
                <div class="prose prose-sm max-w-none text-gray-700 sm:prose-base">
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

                <div class="mt-8">
                    <h3 class="mb-4 text-xl font-bold">Kelas yang Tersedia</h3>

                    @if ($course->classes->isEmpty())
                        <p class="text-gray-500">Saat ini tidak ada kelas yang dibuka untuk pendaftaran.</p>
                    @else
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($course->classes as $class)
                                <div class="rounded-lg border border-gray-200 p-5 hover:shadow-md">
                                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                        <div>
                                            <h4 class="font-bold">{{ $class->name }}</h4>
                                            <p class="mt-1 text-sm text-gray-600">
                                                {!! Str::limit($class->description, 120) !!}
                                            </p>
                                        </div>
                                        <div class="mt-3 md:mt-0">
                                            <form action="{{ route('payment.initiate') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="course_id" value="{{ $course->id }}">
                                                <input type="hidden" name="course_class_id" value="{{ $class->id }}">
                                                <p>{{ $class->id }}</p>
                                                <button type="submit" class="w-full rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700 md:w-auto">
                                                    Daftar & Bayar
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
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
