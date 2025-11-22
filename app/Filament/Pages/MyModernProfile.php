<?php

namespace App\Filament\Pages;

use App\Livewire\MyModernProfile\TwoFactorAuthenticationForm;
use App\Livewire\MyModernProfile\UpdatePasswordForm;
use App\Livewire\MyModernProfile\UpdatePersonalInfoForm;  // Import Livewire components Anda
use Filament\Pages\Page;
// Anda bisa menambahkan Livewire components lain di sini

class MyModernProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $title = 'Profil Pengguna Saya';  // Judul di breadcrumbs dan browser
    protected static string $view = 'filament.pages.my-modern-profile';  // View Blade untuk halaman ini
    // Opsional: Sembunyikan dari navigasi utama jika hanya ingin diakses via user menu
    protected static bool $shouldRegisterNavigation = false;

    // Tambahkan action di header halaman jika perlu
    protected function getHeaderActions(): array
    {
        return [
            // Contoh: Action untuk kembali ke dashboard
            // Action::make('backToDashboard')
            //     ->label('Kembali ke Dashboard')
            //     ->url(fn (): string => Dashboard::getUrl()),
        ];
    }

    // Metode untuk passing data ke view jika diperlukan
    public function getHeaderWidgets(): array
    {
        return [
            // Anda bisa menaruh widget di sini jika ingin
        ];
    }
}
