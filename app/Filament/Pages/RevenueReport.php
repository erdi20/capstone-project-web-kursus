<?php

namespace App\Filament\Pages;

use App\Models\Course;
use App\Models\Payment;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class RevenueReport extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $navigationGroup = 'Laporan';
    protected static string $view = 'filament.pages.revenue-report';

    // Judul halaman
    public function getHeading(): string
    {
        return 'Laporan Pendapatan Kursus';
    }

    // Query utama: agregasi pendapatan per course
    public function getRevenueData(): \Illuminate\Support\Collection
    {
        return Payment::query()
            ->where('transaction_status', 'settlement')
            ->where('fraud_status', 'accept')
            ->select('course_id')
            ->selectRaw('COUNT(student_id) as total_students')
            ->selectRaw('SUM(gross_amount) as total_revenue')
            ->groupBy('course_id')
            ->with('course')  // eager load course
            ->get();
    }

    // Jika tetap ingin pakai Tabel Filament (opsional)
    public function table(Table $table): Table
    {
        return $table
            ->query(
                Payment::query()
                    ->where('transaction_status', 'settlement')
                    ->where('fraud_status', 'accept')
                    ->select('course_id')
                    ->selectRaw('COUNT(student_id) as total_students')
                    ->selectRaw('SUM(gross_amount) as total_revenue')
                    ->groupBy('course_id')
                    ->with('course')
            )
            ->columns([
                Tables\Columns\TextColumn::make('course.name')
                    ->label('Kursus')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_students')
                    ->label('Jumlah Siswa')
                    ->numeric(),
                Tables\Columns\TextColumn::make('total_revenue')
                    ->label('Pendapatan (Rp)')
                    ->money('IDR')
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()->money('IDR'),
                    ]),
            ]);
    }
}
