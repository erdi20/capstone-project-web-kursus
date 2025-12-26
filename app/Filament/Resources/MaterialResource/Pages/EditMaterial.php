<?php

namespace App\Filament\Resources\MaterialResource\Pages;

use App\Filament\Resources\CourseResource;
use App\Filament\Resources\MaterialResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditMaterial extends EditRecord
{
    protected static string $resource = MaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Kembali')
                ->color('gray')
                ->icon('heroicon-o-arrow-left')
                ->url(fn() => CourseResource::getUrl('materials', ['record' => $this->record->course_id])),
            Actions\DeleteAction::make(),
        ];
    }
}
