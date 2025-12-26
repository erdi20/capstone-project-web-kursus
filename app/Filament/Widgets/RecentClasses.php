<?php

namespace App\Filament\Widgets;

use App\Models\Course;
use App\Models\CourseClass;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class RecentClasses extends BaseWidget
{
    protected int|string|array $columnSpan = 'full';

    // ✅ Tambahkan return type: Builder
    protected function getTableQuery(): Builder
    {
        if (!Auth::user()?->isMentor()) {
            return CourseClass::query()->whereRaw('1 = 0');
        }

        return CourseClass::where('created_by', Auth::id())
            ->with('course')  // agar bisa akses $record->course->name
            ->latest('id')
            ->limit(5);
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name')->label('Nama Kelas'),
            Tables\Columns\TextColumn::make('course.name')->label('Kursus'),
            Tables\Columns\TextColumn::make('status')
                ->badge()
                ->color(fn(string $state): string => match ($state) {
                    'open' => 'success',
                    'closed' => 'danger',
                    default => 'gray',
                }),
        ];
    }

    protected function getTableHeading(): string
    {
        return 'Kelas Terbaru Saya';
    }
}
