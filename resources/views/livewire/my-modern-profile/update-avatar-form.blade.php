{{-- resources/views/livewire/my-modern-profile/update-avatar-form.blade.php --}}

<form wire:submit.prevent="submit" class="space-y-4">
    {{-- Form komponen ini berasal dari UpdateProfileAvatar::getAvatarFormComponents() --}}
    {{ $this->form }}

    <div class="flex justify-end gap-3">
        @if (auth()->user()->avatar_url)
            {{-- Tombol Hapus Avatar --}}
            <x-filament::button wire:click="deleteAvatar" color="danger" tag="button" type="button">
                Hapus Avatar
            </x-filament::button>
        @endif

        {{-- Tombol Simpan (akan muncul setelah file dipilih) --}}
        <x-filament::button type="submit" wire:loading.attr="disabled" wire:target="form">
            Simpan Avatar
        </x-filament::button>
    </div>
</form>
