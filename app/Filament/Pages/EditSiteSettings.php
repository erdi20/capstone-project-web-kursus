<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Tabs;
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
                Tabs::make('Pengaturan Utama')
                    ->tabs([
                        // --- TAB BRANDING & IDENTITAS ---
                        Tab::make('Identitas Situs')  // Gunakan Tab::make jika sudah di-import
                            ->icon('heroicon-m-globe-alt')
                            ->schema([
                                Split::make([
                                    // Kolom Kiri: Informasi Utama
                                    Section::make([
                                        TextInput::make('site_name')
                                            ->label('Nama Platform')
                                            ->placeholder('Contoh: EduTech Pro')
                                            ->required()
                                            ->maxLength(50),
                                        Textarea::make('site_description')
                                            ->label('Deskripsi Singkat (SEO)')
                                            ->placeholder('Jelaskan platform Anda dalam beberapa kalimat...')
                                            ->rows(4)
                                            ->required(),
                                        TextInput::make('copyright_text')
                                            ->label('Teks Hak Cipta')
                                            ->placeholder('© 2025 EduTech. All rights reserved.')
                                            ->required(),
                                    ])->grow(),
                                    // Kolom Kanan: Aset Visual & Komisi
                                    Section::make([
                                        FileUpload::make('logo')
                                            ->label('Logo Website')
                                            ->image()
                                            ->imageEditor()
                                            ->directory('settings')
                                            ->disk('public')
                                            ->maxSize(1024)
                                            ->helperText('Format PNG/JPG, Maks 1MB.'),
                                        TextInput::make('mentor_commission_percent')
                                            ->label('Komisi Default Mentor')
                                            ->numeric()
                                            ->suffix('%')
                                            ->helperText('Persentase potongan otomatis per transaksi.')
                                            ->required(),
                                    ])->extraAttributes(['class' => 'w-full md:w-80']),  // Mengatur lebar kanan dengan Tailwind (lebih aman)
                                ])->from('md'),
                            ]),
                        // --- TAB KONTAK & SOSIAL MEDIA ---
                        Tab::make('Kontak & Media Sosial')
                            ->icon('heroicon-m-chat-bubble-left-right')
                            ->schema([
                                Grid::make(3)->schema([
                                    // Section Kontak
                                    Section::make('Informasi Kontak')
                                        ->columnSpan(2)
                                        ->columns(2)
                                        ->schema([
                                            TextInput::make('email')
                                                ->label('Email Support')
                                                ->email()
                                                ->prefixIcon('heroicon-m-envelope')
                                                ->required(),
                                            TextInput::make('phone')
                                                ->label('WhatsApp/Hotline')
                                                ->tel()
                                                ->prefixIcon('heroicon-m-phone')
                                                ->required(),
                                            Textarea::make('address')
                                                ->label('Alamat Kantor')
                                                ->columnSpanFull()
                                                ->rows(2),
                                            TextInput::make('gmaps_embed_url')
                                                ->label('URL Google Maps (Iframe)')
                                                ->placeholder('https://google.com/maps/embed?pb=...')
                                                ->columnSpanFull(),
                                        ]),
                                    // Section Sosial Media
                                    Section::make('Link Sosial Media')
                                        ->columnSpan(1)
                                        ->schema([
                                            Grid::make(1)  // Memastikan tumpukan vertikal yang konsisten
                                                ->schema([
                                                    TextInput::make('facebook_url')
                                                        ->label('Facebook')
                                                        ->prefix('https://facebook.com/')  // Gunakan URL lengkap agar lebih jelas bagi sistem
                                                        ->placeholder('username'),
                                                        TextInput::make('instagram_url')
                                                        ->label('Instagram')
                                                        ->prefix('https://instagram.com/')
                                                        ->placeholder('username'),
                                                        TextInput::make('twitter_url')
                                                        ->label('Twitter')
                                                        ->prefix('https://x.com/')
                                                        ->placeholder('username'),
                                                    TextInput::make('linkedin_url')
                                                        ->label('LinkedIn')
                                                        ->prefix('https://linkedin.com/in/')
                                                        ->placeholder('username'),
                                                ]),
                                        ]),
                                ]),
                            ]),
                    ])
                    ->columnSpanFull()
                    ->persistTabInQueryString(),  // Bagus untuk UX agar saat refresh tetap di tab yang sama
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
