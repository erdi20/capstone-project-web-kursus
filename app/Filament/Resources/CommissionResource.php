<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommissionResource\Widgets\TotalRevenueOverview;
use App\Filament\Resources\CommissionResource\Pages;
use App\Filament\Resources\CommissionResource\RelationManagers;
use App\Models\Commission;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Setting;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CommissionResource extends Resource
{
    protected static ?string $model = Commission::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function canAccess(): bool
    {
        $user = auth()->user();

        // Izinkan akses jika user adalah admin atau mentor
        return $user->isAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        $commissionPercent = Setting::first()?->mentor_commission_percent ?? 70;
        return $table
            ->query(
                Course::with('user')
                    ->whereHas('payments', function ($q) {
                        $q->where('transaction_status', 'settlement');
                    })
                    ->select('courses.*')
                    ->addSelect([
                        'total_revenue' => Payment::selectRaw('SUM(gross_amount)')
                            ->whereColumn('course_id', 'courses.id')
                            ->where('transaction_status', 'settlement'),
                        'mentor_commission' => Payment::selectRaw('(SUM(gross_amount) * ?) / 100', [$commissionPercent])
                            ->whereColumn('course_id', 'courses.id')
                            ->where('transaction_status', 'settlement'),
                    ])
            )
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Kursus'),
                Tables\Columns\TextColumn::make('user.name')->label('Mentor'),
                Tables\Columns\TextColumn::make('total_revenue')
                    ->label('Total Pendapatan')
                    ->money('IDR'),
                    // ->summarize([Sum::make()->money('IDR')]),
                Tables\Columns\TextColumn::make('mentor_commission')
                    ->label('Komisi Mentor')
                    ->money('IDR')
                    // ->summarize([Sum::make()->money('IDR')]),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getWidgets(): array
    {
        return [
            TotalRevenueOverview::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCommissions::route('/'),
        ];
    }
}
