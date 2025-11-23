<?php

namespace App\Filament\Resources\EssayAssignmentResource\Pages;

use App\Filament\Resources\EssayAssignmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEssayAssignment extends EditRecord
{
    protected static string $resource = EssayAssignmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
