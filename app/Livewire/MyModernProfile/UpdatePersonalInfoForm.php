<?php

namespace App\Livewire\MyModernProfile;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Forms;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class UpdatePersonalInfoForm extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Auth::user()->only(['name', 'email', 'phone_number']));
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
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
            ->statePath('data')
            ->model(Auth::user());
    }

    public function updateProfile(): void
    {
        $data = $this->form->getState();
        Auth::user()->update($data);

        Notification::make()
            ->success()
            ->title('Informasi profil berhasil diperbarui.')
            ->send();
    }

    public function render(): View
    {
        return view('livewire.my-modern-profile.update-personal-info-form');
    }
}
