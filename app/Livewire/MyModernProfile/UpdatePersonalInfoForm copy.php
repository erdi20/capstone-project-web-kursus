<?php

namespace App\Livewire\MyModernProfile;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
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
    protected ?string $oldAvatarPath = null;  // <-- tambahkan ini

    public function mount(): void
    {
        $user = auth()->user();
        $this->form->fill([
            'name' => $user->name,
            'email' => $user->email,
            'avatar_url' => $user->avatar_url,
            '_old_avatar' => $user->avatar_url,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('_old_avatar')  // hidden field
                    ->default(fn() => auth()->user()->avatar_url)
                    ->hidden(),
                FileUpload::make('avatar_url')
                    ->disk('public')
                    ->directory('avatars')
                    ->visibility('public')
                    ->image()
                    ->avatar()
                    ->deletable()
                    ->downloadable(false),
                // ->afterStateUpdated(function (?string $state, ?string $old) {
                //     if (filled($old) && blank($state)) {
                //         // Hanya hapus jika file lama ada dan berbeda
                //         if (Storage::disk('public')->exists($old)) {
                //             Storage::disk('public')->delete($old);
                //         }
                //     }
                // }),
                Forms\Components\TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Alamat Email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(table: 'users', ignorable: Auth::user()),
                // Forms\Components\TextInput::make('phone_number')  // Pastikan kolom ini ada di database
                //     ->label('Nomor Telepon')
                //     ->tel()
                //     ->maxLength(20)
                //     ->nullable(),
                // Anda bisa menambahkan Avatars di sini menggunakan Filament Breezy Avatars
                // Forms\Components\FileUpload::make('avatar')
                //     ->label('Avatar Profil')
                //     // ... konfigurasi avatar
            ])
            ->statePath('data');
        // ->model(Auth::user());
    }

    public function updateProfile(): void
    {
        $data = $this->form->getState();

        // ⚡️ Muat ulang user dari database untuk pastikan getOriginal() akurat
        $user = \App\Models\User::find(auth()->id());

        $newAvatar = $data['avatar_url'] ?? null;
        $oldAvatar = $user->getOriginal('avatar_url');  // nilai saat pertama kali diambil dari DB

        Log::info('Avatar Change:', [
            'old' => $oldAvatar,
            'new' => $newAvatar,
            'user_id' => $user->id
        ]);

        // Hanya hapus jika ada avatar lama dan berbeda
        if ($oldAvatar && $oldAvatar !== $newAvatar) {
            if (Storage::disk('public')->exists($oldAvatar)) {
                Storage::disk('public')->delete($oldAvatar);
                Log::info('✅ File lama berhasil dihapus.');
            } else {
                Log::warning('File tidak ditemukan di storage.', ['path' => $oldAvatar]);
            }
        }

        // Simpan ke database
        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'avatar_url' => $newAvatar,
        ]);

        $this->dispatch('filament:refresh-user-avatar');
        
        $this->js('window.location.reload();');
        Notification::make()
            ->success()
            ->title('Profil berhasil diperbarui.')
            ->send();
    }

    public function render(): View
    {
        return view('livewire.my-modern-profile.update-personal-info-form');
    }
}
