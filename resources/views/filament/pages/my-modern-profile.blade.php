<x-filament-panels::page>
    <div class="fi-my-modern-profile grid grid-cols-1 gap-6 md:grid-cols-3">
        {{-- Sisi Kiri: Navigasi Profil atau Ringkasan --}}
        <div class="col-span-1">
            <x-filament::section class="h-full">
                <div class="flex flex-col items-center justify-center p-4">
                    {{-- Avatar (jika ada, bisa pakai filament-breezy-avatars atau custom) --}}
                    {{-- <img src="{{ auth()->user()->avatar_url ?? 'https://via.placeholder.com/150' }}"
                        alt="User Avatar"
                        class="w-24 h-24 rounded-full object-cover mb-4"> --}}

                    <h3 class="mb-1 text-xl font-semibold text-gray-950 dark:text-white">{{ auth()->user()->name }}</h3>
                    <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">{{ auth()->user()->email }}</p>
                </div>

                {{-- Contoh navigasi di sisi kiri (jika ada banyak bagian) --}}
                <nav class="mt-4 flex flex-col space-y-2">
                    <a href="#personal-info" class="text-primary-600 bg-primary-50 dark:bg-primary-400/10 dark:text-primary-400 flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium">
                        <x-filament::icon icon="heroicon-o-user" class="h-5 w-5" />
                        Informasi Pribadi
                    </a>
                    <a href="#password" class="hover:text-primary-600 dark:hover:text-primary-400 flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-800">
                        <x-filament::icon icon="heroicon-o-lock-closed" class="h-5 w-5" />
                        Ubah Kata Sandi
                    </a>
                    @if (config('filament-breezy.enable_2fa'))
                        <a href="#2fa" class="hover:text-primary-600 dark:hover:text-primary-400 flex items-center gap-2 rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 dark:text-gray-200 dark:hover:bg-gray-800">
                            <x-filament::icon icon="heroicon-o-shield-check" class="h-5 w-5" />
                            Autentikasi Dua Faktor
                        </a>
                    @endif
                </nav>
            </x-filament::section>
        </div>

        <div class="col-span-1 space-y-6 md:col-span-2">
            <x-filament::section id="personal-info">
                <x-slot name="heading">Informasi Pribadi</x-slot>
                <x-slot name="description">Perbarui nama, alamat email, dan nomor telepon akun Anda.</x-slot>
                @livewire('my-modern-profile.update-personal-info-form')
            </x-filament::section>

            <x-filament::section id="password">
                <x-slot name="heading">Ubah Kata Sandi</x-slot>
                <x-slot name="description">Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.</x-slot>
                @livewire('my-modern-profile.update-password-form')
            </x-filament::section>

            @if (config('filament-breezy.enable_2fa'))
                <x-filament::section id="2fa">
                    <x-slot name="heading">Autentikasi Dua Faktor</x-slot>
                    <x-slot name="description">Tambahkan keamanan ekstra ke akun Anda menggunakan autentikasi dua faktor.</x-slot>
                    @livewire('my-modern-profile.two-factor-authentication-form')
                </x-filament::section>
            @endif

            {{-- Tambahkan bagian lain seperti API Tokens, Browser Sessions, dll. di sini --}}

            {{-- Contoh: Penghapusan Akun --}}
            <x-filament::section>
                <x-slot name="heading">Hapus Akun</x-slot>
                <x-slot name="description">Setelah akun Anda dihapus, semua sumber dayanya dan datanya akan dihapus secara permanen.</x-slot>
                <x-filament::button color="danger" tag="button">
                    Hapus Akun
                </x-filament::button>
            </x-filament::section>
        </div>
    </div>
</x-filament-panels::page>
