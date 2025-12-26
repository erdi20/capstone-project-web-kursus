<x-guest-layout>
    <div class="mx-auto max-w-4xl px-4 py-12">
        <div class="rounded-[2rem] border border-green-100 bg-white p-10 shadow-sm">
            <div class="mb-8 flex items-center gap-3">
                <div class="rounded-lg bg-green-100 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#20C896]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h1 class="text-3xl font-black text-gray-900">Syarat & Ketentuan</h1>
            </div>

            <div class="prose prose-green max-w-none italic leading-relaxed text-gray-600">
                Terakhir diperbarui: {{ $setting->updated_at->format('d F Y') }}
            </div>

            <div class="prose prose-green mt-8 max-w-none text-gray-700">
                {{-- Menampilkan isi dari database --}}
                {!! $setting->terms_conditions ?? 'Syarat & ketentuan belum tersedia.' !!}
            </div>

            <div class="mt-12 flex items-center justify-between border-t border-gray-100 pt-8">
                <a href="/" class="font-medium text-gray-500 transition hover:text-[#20C896]">
                    &larr; Beranda
                </a>
                <button onclick="window.print()" class="rounded-xl border border-[#20C896] px-4 py-2 text-sm font-bold text-[#20C896] transition hover:bg-green-50">
                    Cetak Dokumen
                </button>
            </div>
        </div>
    </div>
</x-guest-layout>
