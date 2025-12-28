<div>
    {{-- Input Pencarian yang disinkronkan ke $searchTerm --}}
    <div class="mb-6">
        <div class="relative mx-auto max-w-md">
            {{-- Kunci: wire:model.live untuk sinkronisasi real-time --}}
            <input type="text" name="searchCourses" placeholder="Cari kursus..."
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-cyan-500"
                wire:model.live="searchTerm" />
            <button class="absolute right-2 top-1/2 -translate-y-1/2 transform text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
        </div>
    </div>


    <div class="my-8 border-t border-gray-200"></div>

    @if ($courses->isEmpty() && $searchTerm)
        <p class="text-center text-gray-500 text-lg">Tidak ada kursus yang ditemukan untuk "{{ $searchTerm }}".</p>
    @elseif ($courses->isEmpty())
        <p class="text-center text-gray-500 text-lg">Tidak ada kursus yang tersedia saat ini.</p>
    @else
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            {{-- Card --}}
            @foreach ($courses as $item)
                <div
                    class="overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm transition-all duration-300 hover:shadow-md">
                    <a href="{{ route('detailkursus', $item->slug) }}">
                        <div class="relative">
                            {{-- Gunakan asset() --}}
                            <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="Course Image"
                                class="h-48 w-full object-cover">
                        </div>

                        <div class="p-5">
                            <h3 class="mb-2 text-lg font-bold text-cyan-500">{{ $item->name }}</h3>

                            <div class="mb-4 flex items-center gap-3">
                                <img src="{{ asset('storage/' . $item->user->avatar_url) }}" alt="Mentor"
                                    class="h-10 w-10 rounded-full border border-gray-200">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $item->user->name }}</p>
                                    <p class="text-xs text-gray-500">Mentor</p>
                                </div>
                            </div>

                            {{-- Logika Harga (disalin dari listcourse.blade.php) --}}
                            <div class="mb-4 flex items-center justify-between">
                                <div>
                                    @php
                                        // Asumsi Model Course memiliki kolom discount_price dan discount_end_date
                                        $isDiscountActive =
                                            $item->discount_price !== null &&
                                            ($item->discount_end_date === null ||
                                                now()->lessThan($item->discount_end_date));
                                    @endphp

                                    @if ($isDiscountActive)
                                        <p class="text-sm text-gray-400" style="text-decoration: line-through;">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </p>
                                        <p class="text-lg font-bold text-gray-900">
                                            Rp {{ number_format($item->discount_price, 0, ',', '.') }}
                                        </p>
                                    @else
                                        <p class="text-lg font-bold text-gray-900">
                                            Rp {{ number_format($item->price, 0, ',', '.') }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
