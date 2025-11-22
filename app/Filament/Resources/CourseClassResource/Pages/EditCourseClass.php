<?php

namespace App\Filament\Resources\CourseClassResource\Pages;

use App\Filament\Resources\CourseClassResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCourseClass extends EditRecord
{
    protected static string $resource = CourseClassResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
