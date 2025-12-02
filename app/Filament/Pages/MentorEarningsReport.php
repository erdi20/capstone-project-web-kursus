<?php

namespace App\Filament\Pages;

use App\Models\Course;
use App\Models\Payment;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;

class MentorEarningsReport extends Page implements HasTable
{
    use InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static string $view = 'filament.pages.mentor-earnings-report';

    public static function canAccess(): bool
    {
        $user = auth()->user();

        // Izinkan akses jika user adalah admin atau mentor
        return $user->isMentor();
    }

    public function getHeading(): string
    {
        return 'Laporan Pendapatan Mentor';
    }

    public static function shouldRegisterNavigation(): bool
    {
        return true;  // muncul di menu
    }

    public function table(Table $table): Table
    {
        $userId = auth()->id();

        $query = Payment::query()
            ->join('courses', 'payments.course_id', '=', 'courses.id')
            ->where('courses.created_by', $userId)
            ->where('payments.transaction_status', 'settlement')
            ->where('payments.fraud_status', 'accept')
            ->selectRaw('
        payments.course_id,
        courses.name as course_name,
        COUNT(DISTINCT payments.student_id) as total_enrollments, -- ✅ Hanya hitung siswa unik
        SUM(payments.gross_amount) as total_gross,
        SUM(payments.gross_amount) * 0.9 as mentor_earnings,
        MAX(payments.settlement_at) as last_payment_at
    ')
            ->groupBy('payments.course_id', 'courses.name');

        return $table
            ->query($query)
            ->defaultSort('mentor_earnings', 'desc')  // ✅ tentukan sort eksplisit
            ->columns([
                TextColumn::make('course_name')->label('Kursus'),
                TextColumn::make('total_enrollments')->label('Jumlah Pendaftar')->alignCenter(),
                TextColumn::make('total_gross')
                    ->label('Pendapatan Kotor')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.')),
                TextColumn::make('mentor_earnings')
                    ->label('Pendapatan Mentor (90%)')
                    ->formatStateUsing(fn($state) => 'Rp ' . number_format($state, 0, ',', '.'))
                    ->color('success')
                    ->weight('bold'),
                TextColumn::make('last_payment_at')
                    ->label('Pembayaran Terakhir')
                    ->dateTime('d M Y'),
            ]);
    }

    public function getTableRecordKey($record): string
    {
        return (string) $record->course_id;
    }
}
