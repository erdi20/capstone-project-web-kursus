<?php

namespace App\Filament\Widgets;

use App\Models\CourseClass;
use App\Models\EssayAssignment;
use App\Models\QuizAssignment;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class MentorOverview extends BaseWidget
{
    protected function getStats(): array
    {
        if (!Auth::user()->isMentor()) {
            Log::info('Bukan mentor');
            return [];
        }

        $userId = Auth::id();
        $kelasAktif = CourseClass::where('created_by', $userId)->where('status', 'open')->count();
        $essay = EssayAssignment::where('created_by', $userId)->count();
        $quiz = QuizAssignment::where('created_by', $userId)->count();

        Log::info('Mentor stats', [
            'user_id' => $userId,
            'kelas_aktif' => $kelasAktif,
            'essay' => $essay,
            'quiz' => $quiz
        ]);

        return [
            Stat::make('Kelas Aktif', $kelasAktif)
                ->icon('heroicon-o-book-open')
                ->color('success'),
            Stat::make('Tugas Essay', $essay)
                ->icon('heroicon-o-document-text')
                ->color('indigo'),
            Stat::make('Tugas Quiz', $quiz)
                ->icon('heroicon-o-clipboard-document-check')
                ->color('purple'),
        ];
    }
}
