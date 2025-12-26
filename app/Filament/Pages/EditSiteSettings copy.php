<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class EditSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $view = 'filament.pages.edit-site-settings';
    // --- Pengaturan Navigasi & Label ---
    protected static ?string $navigationLabel = 'Identitas Situs';  // Lebih spesifik (Logo, Nama, Kontak)
    protected static ?string $navigationGroup = 'Konten Website';  // Disatukan dengan Slider & FAQ agar tidak terlalu banyak grup
    protected static ?string $slug = 'konfigurasi-situs';
    // --- Pengaturan Visual ---
    protected static ?string $navigationIcon = 'heroicon-o-adjustments-horizontal';  // Ikon pengaturan yang lebih modern
    protected static ?string $activeNavigationIcon = 'heroicon-s-adjustments-horizontal';
    protected static ?int $navigationSort = 3;  // Urutan terakhir setelah Slider (1) dan FAQ (2)

    // --- Pengaturan Heading ---
    protected ?string $heading = 'Konfigurasi Identitas Situs';
    protected ?string $subheading = 'Kelola informasi publik, logo, dan kontak resmi platform Anda.';

    // --- Pengaturan UX ---
    protected static ?string $navigationBadgeTooltip = 'Periksa konfigurasi situs secara berkala';

    public ?array $data = [];

    public static function canAccess(): bool
    {
        $user = auth()->user();

        // Izinkan akses jika user adalah admin atau mentor
        return $user->isAdmin();
    }

    public function mount(): void
    {
        // Mengambil data pertama, atau array kosong jika tidak ada
        $setting = Setting::first();

        if ($setting) {
            $this->form->fill($setting->toArray());
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Branding')
                    ->schema([
                        TextInput::make('site_name')
                            ->label('Nama Situs')
                            ->required(),
                        Textarea::make('site_description')
                            ->label('Deskripsi Situs')
                            ->rows(3)
                            ->required(),
                        FileUpload::make('logo')
                            ->label('Logo Situs')
                            ->image()  // Memastikan hanya file gambar
                            ->directory('settings')  // Akan disimpan di storage/app/public/settings
                            ->disk('public')  // Wajib agar bisa diakses publik
                            ->visibility('public')
                            ->imagePreviewHeight('150')  // Opsional: mengatur tinggi preview
                            ->downloadable()  // Opsional: agar bisa didownload
                            ->openable(),  // Opsional: agar bisa dilihat di tab baru
                        TextInput::make('mentor_commission_percent')
                            ->label('Persentase Komisi Mentor (%)')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->suffix('%')
                            ->required(),
                    ]),
                Section::make('Kontak & Lokasi')
                    ->columns(2)
                    ->schema([
                        TextInput::make('email')
                            ->label('Email Kontak')
                            ->email()
                            ->required(),
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->required(),
                        Textarea::make('address')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->columnSpanFull()
                            ->required(),
                        Textarea::make('gmaps_embed_url')
                            ->label('Google Maps Embed URL')
                            ->helperText('Tempel URL embed dari Google Maps (iframe src)')
                            ->rows(2)
                            ->columnSpanFull()
                            ->required(),
                    ]),
                Section::make('Media Sosial')
                    ->columns(2)
                    ->schema([
                        TextInput::make('facebook_url')->url()->label('Facebook URL'),
                        TextInput::make('twitter_url')->url()->label('Twitter URL'),
                        TextInput::make('instagram_url')->url()->label('Instagram URL'),
                        TextInput::make('linkedin_url')->url()->label('LinkedIn URL'),
                    ]),
                Section::make('Footer')
                    ->schema([
                        TextInput::make('copyright_text')
                            ->label('Teks Copyright')
                            ->required(),
                    ]),
            ])
            ->statePath('data');
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Simpan Perubahan')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            // Menggunakan updateOrCreate agar aman jika record belum ada di DB
            Setting::updateOrCreate(
                ['id' => 1],  // Mengasumsikan kita hanya pakai 1 row ID 1
                $data
            );

            Notification::make()
                ->success()
                ->title('Pengaturan berhasil diperbarui')
                ->send();
        } catch (\Exception $e) {
            Notification::make()
                ->danger()
                ->title('Terjadi kesalahan')
                ->body($e->getMessage())
                ->send();
        }
    }
}
