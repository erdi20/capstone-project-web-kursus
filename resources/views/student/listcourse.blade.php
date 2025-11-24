<x-app-layout>
    <div class="mx-auto max-w-7xl px-4 py-8">
        <!-- Header -->
        <h1 class="mb-6 text-2xl font-bold text-gray-900">Halaman Kelas: Semua Pencarian dan Kategori</h1>

        <!-- Search Bar -->
        <div class="mb-6">
            <div class="relative mx-auto max-w-md">
                <input type="text" placeholder="Cari kursus..." class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-cyan-500" />
                <button class="absolute right-2 top-1/2 -translate-y-1/2 transform text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>

        <div class="mb-8 flex justify-center">
            <button class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50">
                📋 Filter Kelas
            </button>
        </div>

        <div class="my-8 border-t border-gray-200"></div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            {{-- Card --}}
            @foreach ($courses as $item)
                <div class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm transition-all duration-300 hover:shadow-md">
                    <div class="relative">
                        <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="Course Image" class="h-48 w-full object-cover">
                        {{-- <div class="absolute left-3 top-3 rounded-full bg-cyan-400 px-3 py-1 text-xs font-bold text-white">
                        SEMUA TINGKAT
                    </div> --}}
                    </div>

                    <div class="p-5">
                        <h3 class="mb-2 text-lg font-bold text-cyan-500">{{ $item->name }}</h3>

                        {{-- <p class="mb-4 text-sm text-gray-600">21.5 jam | 186 Video</p> --}}

                        <div class="mb-4 flex items-center gap-3">
                            <img src="{{ asset('storage/' . $item->user->avatar_url) }}" alt="Mentor" class="h-10 w-10 rounded-full border border-gray-200">
                            <div>
                                <p class="font-medium text-gray-800">{{ $item->user->name }}</p>
                                <p class="text-xs text-gray-500">Mentor</p>
                            </div>
                        </div>

                        <div class="mb-4 flex items-center justify-between">
                            <div>
                                @php
                                    $isDiscountActive = $item->discount_price !== null && ($item->discount_end_date === null || now()->lessThan($item->discount_end_date));
                                @endphp

                                @if ($isDiscountActive)
                                    {{-- Tampilan Diskon Aktif --}}
                                    <p class="text-sm text-gray-400" style="text-decoration: line-through;">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                    <p class="text-lg font-bold text-gray-900">
                                        Rp {{ number_format($item->discount_price, 0, ',', '.') }}
                                    </p>
                                @else
                                    {{-- Tampilan Harga Normal --}}
                                    <p class="text-lg font-bold text-gray-900">
                                        Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                @endif
                            </div>
                            {{-- <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.917c1.927-1.927 5.07-1.927 6.998 0L22 9a2 2 0 01-2 2h-5l-5 5v-5H4a2 2 0 01-2-2V9zM18 13a2 2 0 01-2 2h-6l-2 2v-2H6a2 2 0 01-2-2v-6a2 2 0 012-2h6l2-2v2h5a2 2 0 012 2v6z" />
                            </svg>
                            <span class="font-medium text-gray-800">4.9 (2136)</span>
                        </div> --}}
                        </div>

                        <!-- Label Terlaris -->
                        <div class="mt-2">
                            {{-- <span class="inline-block rounded-full bg-cyan-100 px-3 py-1 text-xs font-bold text-cyan-700">
                                TERLARIS
                            </span> --}}
                        </div>
                    </div>
                </div>
            @endforeach

        </div>


    </div>
</x-app-layout>
