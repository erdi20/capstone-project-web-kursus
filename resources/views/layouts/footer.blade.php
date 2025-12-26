@php
    $setting = \App\Models\Setting::first();
@endphp

<footer class="bg-gray-800 py-10 text-gray-300">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-10 grid grid-cols-1 gap-8 md:grid-cols-4">

            {{-- Kolom 1: Branding/Tentang Kami --}}
            <div>
                <h3 class="mb-4 text-xl font-bold text-white">{{ $setting?->site_name ?: 'Qualitative Research Class' }}</h3>
                <p class="text-sm">
                    {{ $setting?->site_description ?: 'Membantu Anda menguasai metode penelitian kualitatif dengan panduan praktis dan dukungan komunitas.' }}
                </p>
                <div class="mt-6 flex space-x-4">
                    @if ($setting?->facebook_url)
                        <a href="{{ $setting->facebook_url }}" class="text-gray-400 transition duration-300 hover:text-white" target="_blank" rel="noopener">
                            <i class="fab fa-facebook-f text-lg"></i>
                        </a>
                    @endif
                    @if ($setting?->twitter_url)
                        <a href="{{ $setting->twitter_url }}" class="text-gray-400 transition duration-300 hover:text-white" target="_blank" rel="noopener">
                            <i class="fab fa-twitter text-lg"></i>
                        </a>
                    @endif
                    @if ($setting?->instagram_url)
                        <a href="{{ $setting->instagram_url }}" class="text-gray-400 transition duration-300 hover:text-white" target="_blank" rel="noopener">
                            <i class="fab fa-instagram text-lg"></i>
                        </a>
                    @endif
                    @if ($setting?->linkedin_url)
                        <a href="{{ $setting->linkedin_url }}" class="text-gray-400 transition duration-300 hover:text-white" target="_blank" rel="noopener">
                            <i class="fab fa-linkedin-in text-lg"></i>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Kolom 2: Navigasi Cepat --}}
            <div>
                <h3 class="mb-4 text-lg font-semibold text-white">Navigasi</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('dashboard') }}" class="text-sm transition duration-300 hover:text-white">Beranda</a></li>
                    <li><a href="{{ route('listkursus') }}" class="text-sm transition duration-300 hover:text-white">Kursus</a></li>
                    <li><a href="{{ route('listkelas') }}" class="text-sm transition duration-300 hover:text-white">Kelas Saya</a></li>
                    <li><a href="#" class="text-sm transition duration-300 hover:text-white">Blog</a></li>
                </ul>
            </div>

            {{-- Kolom 3: Bantuan & Dukungan --}}
            <div>
                <h3 class="mb-4 text-lg font-semibold text-white">Bantuan</h3>
                <ul class="space-y-2">
                    <li><a href="{{ route('dashboard') }}#faq-section" class="text-sm transition duration-300 hover:text-white">FAQ</a></li>
                    <li><a href="{{ route('contact.us') }}" class="text-sm transition duration-300 hover:text-white">Hubungi Kami</a></li>
                    <li><a href="{{ route('privacy.policy') }}" class="text-sm transition duration-300 hover:text-white">Kebijakan Privasi</a></li>
                    <li><a href="{{ route('terms') }}" class="text-sm transition duration-300 hover:text-white">Syarat & Ketentuan</a></li>
                </ul>
            </div>

            {{-- Kolom 4: Berlangganan / Kontak Singkat --}}
            <div>
                <h3 class="mb-4 text-lg font-semibold text-white">Ikuti Kami</h3>
                <p class="mb-4 text-sm">Dapatkan update terbaru langsung ke inbox Anda.</p>
                <form>
                    <input type="email" placeholder="Email Anda" class="w-full rounded-md border-gray-600 bg-gray-700 p-2 text-sm text-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="mt-3 w-full rounded-md bg-blue-600 py-2 font-semibold text-white transition duration-300 hover:bg-blue-700">
                        Subscribe
                    </button>
                </form>
            </div>

        </div>

        {{-- Bagian Copyright --}}
        <div class="border-t border-gray-700 pt-8 text-center text-sm">
            {!! $setting?->copyright_text ?: '&copy; ' . date('Y') . ' Qualitative Research Class. All rights reserved.' !!}
        </div>
    </div>
</footer>
