<?php

namespace App\Livewire\MyModernProfile;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Grid;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class UpdatePersonalInfoForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $user = auth()->user();

        // 1. Masukkan semua kolom ke dalam form fill
        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'avatar_url' => $user->avatar_url,
            'phone' => $user->phone,
            'address' => $user->address,
            'birth_date' => $user->birth_date,
            'gender' => $user->gender,
            'education_level' => $user->education_level,
            'bio' => $user->bio,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // Bagian Avatar
                FileUpload::make('avatar_url')
                    ->label('Foto Profil')
                    ->disk('public')
                    ->directory('avatars')
                    ->image()
                    ->avatar()
                    ->columnSpanFull(),

                // Grid untuk Nama dan Email
                Grid::make(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Alamat Email')
                            ->email()
                            ->required()
                            ->unique(table: 'users', ignorable: auth()->user()),
                    ]),

                // 2. Tambahkan Input untuk kolom baru
                Grid::make(2)
                    ->schema([
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->placeholder('0812xxxx'),

                        DatePicker::make('birth_date')
                            ->label('Tanggal Lahir')
                            ->native(false) // Tampilan kalender lebih modern
                            ->displayFormat('d/m/Y'),

                        Select::make('gender')
                            ->label('Jenis Kelamin')
                            ->options([
                                'male' => 'Laki-laki',
                                'female' => 'Perempuan',
                            ]),

                        Select::make('education_level')
                            ->label('Tingkat Pendidikan')
                            ->options([
                                'SD' => 'SD',
                                'SMP' => 'SMP',
                                'SMA/SMK' => 'SMA/SMK',
                                'S1' => 'S1',
                                'S2' => 'S2',
                                'S3' => 'S3',
                            ]),
                    ]),

                Textarea::make('address')
                    ->label('Alamat Lengkap')
                    ->rows(3),

                Textarea::make('bio')
                    ->label('Bio / Tentang Saya')
                    ->rows(3)
                    ->placeholder('Ceritakan singkat tentang diri Anda...'),
            ])
            ->statePath('data');
    }

    public function updateProfile(): void
    {
        $data = $this->form->getState();
        $user = \App\Models\User::find(auth()->id());

        // Logika hapus avatar lama (tetap dipertahankan dari kode Anda)
        $newAvatar = $data['avatar_url'] ?? null;
        $oldAvatar = $user->getOriginal('avatar_url');

        if ($oldAvatar && $oldAvatar !== $newAvatar) {
            if (Storage::disk('public')->exists($oldAvatar)) {
                Storage::disk('public')->delete($oldAvatar);
            }
        }

        // 3. Simpan SEMUA data ke database
        // Karena key di $data sudah sama dengan kolom di database, kita bisa gunakan array merge atau update langsung
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar_url' => $newAvatar,
            'phone' => $data['phone'],
            'address' => $data['address'],
            'birth_date' => $data['birth_date'],
            'gender' => $data['gender'],
            'education_level' => $data['education_level'],
            'bio' => $data['bio'],
        ]);

        $this->dispatch('filament:refresh-user-avatar');

        Notification::make()
            ->success()
            ->title('Profil berhasil diperbarui.')
            ->send();

        // Gunakan reload jika ingin merefresh UI secara total (opsional)
        // $this->js('window.location.reload();');
    }

    public function render(): View
    {
        return view('livewire.my-modern-profile.update-personal-info-form');
    }
}
