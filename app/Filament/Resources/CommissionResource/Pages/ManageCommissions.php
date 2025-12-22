<?php

namespace App\Filament\Resources\CommissionResource\Pages;

use App\Filament\Resources\CommissionResource\Widgets\TotalRevenueOverview;
use App\Filament\Resources\CommissionResource;
use Filament\Resources\Pages\ManageRecords;
use Filament\Actions;

class ManageCommissions extends ManageRecords
{
    protected static string $resource = CommissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TotalRevenueOverview::class,
        ];
    }
}
