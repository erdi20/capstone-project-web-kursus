<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Judul Halaman -->
            <h2 class="mb-8 text-3xl font-extrabold tracking-tight text-gray-900">
                Kelas Anda
            </h2>

            <!-- Grid Responsif untuk Kartu Kelas -->
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($enrolledClasses as $class)
                    <!-- START: Kartu Kelas Elegan -->
                    <!-- Gunakan tag 'a' agar seluruh kartu bisa diklik. Sesuaikan rute Anda! -->
                    <a href="{{ route('kelas', $class->id) }}" class="block">
                        <div class="transform overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-xl transition duration-300 ease-in-out hover:scale-[1.03] hover:border-indigo-400 hover:shadow-2xl">

                            <!-- Header Visual Tipis -->
                            <!-- Ganti warna indigo-500 dengan warna yang merepresentasikan status atau kategori kelas -->
                            <div class="h-2 bg-indigo-500"></div>

                            <div class="p-6">
                                <!-- Informasi Utama Kelas -->
                                <div class="mb-4">
                                    <h3 class="text-xl font-bold leading-tight text-gray-900">
                                        {{ $class->course->name ?? 'Nama Kursus' }}
                                    </h3>
                                    <p class="mt-1 text-lg font-medium text-indigo-600">
                                        Kelas {{ $class->name }}
                                    </p>
                                </div>

                                <!-- Detail Tambahan (Contoh data dummy) -->
                                <div class="mb-6 space-y-1 text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg class="mr-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>Durasi: 12 Minggu</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="mr-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>{{ $class->createdBy->name }}</span>
                                    </div>
                                </div>

                                <!-- Status dan CTA (Call to Action) -->
                                <div class="flex items-center justify-between border-t border-gray-100 pt-4">

                                    <!-- Label Status yang Berwarna -->
                                    <span class="<!-- Logika penentuan warna status --> @php $status = strtolower($class->status); @endphp @if ($status == 'aktif') @elseif ($status == 'selesai') @elseif ($status == 'dalam proses') @else @endif bg-blue-100px-3 inline-flex items-center rounded-full py-1 text-xs font-semibold uppercase tracking-wider text-blue-800">
                                        {{ $class->status }}
                                    </span>

                                    <!-- Tombol/Link Aksi -->
                                    <span class="flex items-center text-sm font-semibold text-indigo-600 transition duration-150 hover:text-indigo-800">
                                        Mulai Belajar
                                        <svg class="ml-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                        </svg>
                                    </span>
                                </div>

                            </div>
                        </div>
                    </a>
                    <!-- END: Kartu Kelas Elegan -->
                @endforeach
            </div>

            <!-- Kondisi jika tidak ada kelas (Optional UX) -->
            @if ($enrolledClasses->isEmpty())
                <div class="mt-10 rounded-2xl border-t-4 border-indigo-500 bg-white p-12 text-center shadow-lg">
                    <p class="mb-4 text-xl font-medium text-gray-800">Ups! Anda belum terdaftar di kelas mana pun.</p>
                    <p class="mb-6 text-gray-600">Segera cari kursus yang menarik untuk memulai perjalanan belajar Anda!</p>
                    <!-- Tombol CTA besar -->
                    <a href="#" class="inline-block transform rounded-xl bg-indigo-600 px-8 py-3 font-semibold text-white shadow-md transition hover:scale-105 hover:bg-indigo-700">
                        Telusuri Semua Kursus
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
