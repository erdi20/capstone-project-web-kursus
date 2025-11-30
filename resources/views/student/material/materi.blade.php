<x-app-layout>
    <div class="mx-auto max-w-6xl px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm text-gray-600">
            {{-- <a href="{{ route('my-classes') }}" class="hover:underline">Kelas Saya</a> --}}
            <a href="" class="hover:underline">Kelas Saya</a>
            <span class="mx-2">/</span>
            {{-- <a href="{{ route('kelas', $class->id) }}" class="hover:underline">{{ $class->course->name }}</a> --}}
            <a href="" class="hover:underline">{{ $class->course->name }}</a>
            <span class="mx-2">/</span>
            <span class="font-medium text-gray-800">{{ $material->name }}</span>
        </nav>

        <!-- Header Materi -->
        <div class="mb-8">
            <h1 class="text-2xl font-extrabold text-slate-800">{{ $material->name }}</h1>
            {{-- <p class="mt-2 text-gray-600">Materi {{ $class->materials->search($material)->key + 1 ?? '?' }} dari {{ $class->materials->count() }}</p> --}}
        </div>

        <!-- Konten Utama -->
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- KIRI: Konten Materi -->
            <div class="lg:col-span-2">
                <div class="rounded-xl bg-white p-6 shadow-sm">

                    <!-- Video (jika ada) -->
                    @if ($material->link_video)
                        <div class="mb-6 aspect-video overflow-hidden rounded-lg bg-black">
                            <iframe src="https://www.youtube.com/embed/{{ $material->link_video }}" class="h-full w-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
                            </iframe>
                        </div>
                    @endif

                    <!-- Gambar (jika ada) -->
                    @if ($material->image)
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $material->image) }}" alt="Ilustrasi Materi" class="w-full rounded-lg shadow">
                        </div>
                    @endif

                    <!-- PDF (jika ada) -->
                    @if ($material->pdf)
                        <div class="mb-6 rounded-lg border border-gray-200 bg-gray-50 p-4">
                            <h3 class="mb-2 font-semibold text-gray-800">Dokumen Pendukung</h3>
                            <a href="{{ asset('storage/' . $material->pdf) }}" target="_blank" class="inline-flex items-center text-blue-600 hover:underline">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Lihat PDF
                            </a>
                        </div>
                    @endif

                    <!-- Konten Teks -->
                    @if ($material->content)
                        <div class="prose prose-slate max-w-none">
                            {!! $material->content !!}
                        </div>
                    @else
                        <p class="italic text-gray-500">Tidak ada konten teks untuk materi ini.</p>
                    @endif

                </div>
            </div>

            <!-- KANAN: Navigasi & Progress -->
            <div class="lg:col-span-1">
                <div class="sticky top-6 rounded-xl bg-white p-6 shadow-sm">
                    <h3 class="mb-4 text-lg font-bold text-slate-800">Daftar Materi</h3>

                    <div class="space-y-2">
                        @foreach ($class->materials as $mat)
                            <a href="{{ route('materials.show', [$class->id, $mat->id]) }}" class="{{ $mat->id == $material->id ? 'bg-blue-50 border border-blue-200 text-blue-700' : 'hover:bg-gray-50 text-gray-700' }} block rounded-lg p-3">
                                <span class="font-medium">{{ $loop->iteration }}.</span>
                                <span class="ml-2">{{ Str::limit($mat->name, 30) }}</span>
                            </a>
                        @endforeach
                    </div>

                    <!-- Progress -->
                    <div class="mt-6 border-t border-gray-200 pt-4">
                        <div class="mb-1 flex justify-between text-sm text-gray-600">
                            <span>Kemajuan Kelas</span>
                            <span>{{ $enrollment->progress_percentage ?? 0 }}%</span>
                        </div>
                        <div class="h-2 w-full rounded-full bg-gray-200">
                            <div class="h-full rounded-full bg-gradient-to-r from-blue-500 to-indigo-600" style="width: {{ $enrollment->progress_percentage ?? 0 }}%"></div>
                        </div>
                    </div>

                    <!-- Tombol Kembali -->
                    <a href="{{ route('kelas', $class->id) }}" class="mt-6 flex items-center text-sm text-gray-600 hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="mr-1 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Kelas
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
