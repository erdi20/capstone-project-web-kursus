<x-filament-panels::page>
    <div class="fi-my-modern-profile grid grid-cols-1 gap-6 md:grid-cols-3">
        {{-- Sidebar Profil - Dibuat Sticky & Lebih Kaya Visual --}}
        <div class="col-span-1">
            <x-filament::section class="sticky top-6">
                <div class="flex flex-col items-center justify-center p-5 text-center">
                    {{-- Avatar Dinamis --}}
                    @php
                        $user = auth()->user();
                        $avatarUrl = null;

                        // Coba ambil avatar via Breezy (jika diaktifkan)
                        if (method_exists($user, 'getFilamentAvatarUrl')) {
                            $avatarUrl = $user->getFilamentAvatarUrl();
                        } elseif (!empty($user->avatar)) {
                            // Jika pakai kolom `avatar` di database
                            $avatarUrl = \Storage::url($user->avatar);
                        }
                    @endphp

                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                    <p class="mt-1 rounded-full bg-gray-100 px-2 py-1 text-xs text-gray-600 dark:bg-gray-800 dark:text-gray-300">
                        {{ \Filament\Models\User::class === get_class(auth()->user()) ? 'Member' : 'Admin' }}
                    </p>
                </div>

                {{-- Navigasi Profil dengan Active State --}}
                <nav class="mt-6 flex flex-col space-y-1">
                    @php
                        $sections = [
                            'personal-info' => ['icon' => 'heroicon-o-user', 'label' => 'Informasi Pribadi'],
                            'password' => ['icon' => 'heroicon-o-lock-closed', 'label' => 'Ubah Kata Sandi'],
                            '2fa' => ['icon' => 'heroicon-o-shield-check', 'label' => '2FA'],
                        ];
                        $active = request()->query('section', 'personal-info');
                    @endphp

                    <a href="?section=personal-info" class="{{ $active === 'personal-info' ? 'bg-primary-50 text-primary-700 dark:bg-primary-500/10 dark:text-primary-400 font-medium' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition-colors">
                        <x-filament::icon icon="heroicon-o-user" class="h-5 w-5" />
                        Informasi Pribadi
                    </a>
                    <a href="?section=password" class="{{ $active === 'password' ? 'bg-primary-50 text-primary-700 dark:bg-primary-500/10 dark:text-primary-400 font-medium' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition-colors">
                        <x-filament::icon icon="heroicon-o-lock-closed" class="h-5 w-5" />
                        Ubah Kata Sandi
                    </a>
                    <a href="?section=delete" class="{{ $active === 'delete' ? 'bg-primary-50 text-primary-700 dark:bg-primary-500/10 dark:text-primary-400 font-medium' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition-colors">
                        <x-filament::icon icon="heroicon-o-trash" class="h-5 w-5" />
                        Hapus akun
                    </a>
                    @if (config('filament-breezy.enable_2fa'))
                        <a href="?section=2fa" class="{{ $active === '2fa' ? 'bg-primary-50 text-primary-700 dark:bg-primary-500/10 dark:text-primary-400 font-medium' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800' }} flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm transition-colors">
                            <x-filament::icon icon="heroicon-o-shield-check" class="h-5 w-5" />
                            Autentikasi Dua Faktor
                        </a>
                    @endif
                </nav>
            </x-filament::section>
        </div>

        {{-- Konten Utama - Tampilkan Hanya Bagian Aktif --}}
        <div class="col-span-1 space-y-6 md:col-span-2">
            @if ($active === 'personal-info')
                <x-filament::section>
                    <x-slot name="heading">Informasi Pribadi</x-slot>
                    <x-slot name="description">Perbarui nama dan email akun Anda.</x-slot>
                    @livewire('my-modern-profile.update-personal-info-form')
                </x-filament::section>
            @elseif ($active === 'password')
                <x-filament::section>
                    <x-slot name="heading">Ubah Kata Sandi</x-slot>
                    <x-slot name="description">Gunakan kata sandi yang kuat dengan kombinasi huruf besar, kecil, angka, dan simbol.</x-slot>
                    @livewire('my-modern-profile.update-password-form')
                </x-filament::section>
            @elseif ($active === '2fa' && config('filament-breezy.enable_2fa'))
                <x-filament::section>
                    <x-slot name="heading">Autentikasi Dua Faktor</x-slot>
                    <x-slot name="description">Lindungi akun Anda dengan verifikasi berbasis waktu.</x-slot>
                    @livewire('my-modern-profile.two-factor-authentication-form')
                </x-filament::section>
            @elseif ($active === 'delete')
                <x-filament::section>
                    <x-slot name="heading" class="text-danger-600 dark:text-danger-400">Bahaya: Hapus Akun</x-slot>
                    <x-slot name="description">Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus secara permanen.</x-slot>
                    <x-filament::button color="danger" wire:click="confirmDelete" tag="button">
                        Hapus Akun
                    </x-filament::button>
                </x-filament::section>
            @endif

            {{-- Bagian Hapus Akun - Selalu Tampil di Bawah --}}

        </div>
    </div>
</x-filament-panels::page>
