<x-guest-layout>
    <div class="py-4">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-black text-gray-900 dark:text-white">Hubungi Kami</h1>
            <p class="mt-4 text-gray-600 dark:text-gray-400">Ada pertanyaan? Kami siap membantu Anda menguasai penelitian kualitatif.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10 items-start">
            {{-- Info Kontak --}}
            <div class="space-y-6">
                <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-3xl border border-green-50 dark:border-gray-600 flex items-center gap-5 transition hover:shadow-md">
                    <div class="bg-[#20C896] p-4 rounded-2xl text-white shadow-lg shadow-green-200">
                        <i class="fas fa-envelope text-xl"></i>
                    </div>
                    <div class="overflow-hidden">
                        <h4 class="font-bold text-gray-900 dark:text-white">Email</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm truncate">{{ $setting->email }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-3xl border border-green-50 dark:border-gray-600 flex items-center gap-5 transition hover:shadow-md">
                    <div class="bg-[#20C896] p-4 rounded-2xl text-white shadow-lg shadow-green-200">
                        <i class="fas fa-phone text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">Telepon / WA</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $setting->phone }}</p>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700/50 p-6 rounded-3xl border border-green-50 dark:border-gray-600 flex items-center gap-5 transition hover:shadow-md">
                    <div class="bg-[#20C896] p-4 rounded-2xl text-white shadow-lg shadow-green-200">
                        <i class="fas fa-map-marker-alt text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900 dark:text-white">Alamat</h4>
                        <p class="text-gray-600 dark:text-gray-400 text-sm italic">{{ $setting->address }}</p>
                    </div>
                </div>
            </div>

            {{-- Google Maps --}}
            <div class="lg:col-span-2">
                <div class="overflow-hidden rounded-[2.5rem] border-8 border-white dark:border-gray-700 shadow-2xl h-[450px] relative">
                    @if($setting->gmaps_embed_url)
                        <iframe
                            src="{{ $setting->gmaps_embed_url }}"
                            width="100%"
                            height="100%"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            class="grayscale hover:grayscale-0 transition-all duration-500"
                        ></iframe>
                    @else
                        <div class="w-full h-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500">
                            Peta tidak tersedia
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
