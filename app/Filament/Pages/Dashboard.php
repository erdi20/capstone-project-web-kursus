<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\AdminStatsOverview;
use App\Filament\Widgets\MentorOverview;
use App\Filament\Widgets\RecentClasses;
use App\Models\Course;
use App\Models\CourseClass;
use App\Models\EssayAssignment;
use App\Models\QuizAssignment;
use App\Models\User;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\StatsOverviewWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Dashboard extends BaseDashboard
{
    public function getColumns(): int
    {
        return Auth::user()->isAdmin() ? 3 : 2;
    }

    public function getWidgets(): array
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            return [AdminStatsOverview::class];
        }

        if ($user->isMentor()) {
            return [
                MentorOverview::class,
                RecentClasses::class
            ];
        }

        return [];
    }
}
