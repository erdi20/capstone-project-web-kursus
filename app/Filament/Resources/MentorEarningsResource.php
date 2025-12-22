<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MentorEarningsResource\Pages\ManageMentorEarnings;
use App\Filament\Resources\MentorEarningsResource\Widgets\MentorTotalEarnings;
use App\Models\Commission;
use App\Models\Course;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Withdrawal;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Table;
use Filament\Tables;

class MentorEarningsResource extends Resource
{
    protected static ?string $model = Commission::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Pendapatan Saya';
    protected static ?string $cluster = null;  // atau sesuaikan cluster

    // Hanya tampilkan kursus milik mentor yang sedang login
    // public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    // {
    //     return parent::getEloquentQuery()
    //         ->where('mentor_id', auth()->id())
    //         ->with(['payment.course']);
    // }

    public static function table(Table $table): Table
    {
        return $table
            ->query(
                Commission::where('mentor_id', auth()->id())
                    ->select('courses.id as id')  // ganti dari course_id ke courses.id
                    ->selectRaw('courses.name as course_name')
                    ->selectRaw('SUM(commissions.amount) as total_earnings')
                    ->join('payments', 'commissions.payment_id', '=', 'payments.id')
                    ->join('courses', 'payments.course_id', '=', 'courses.id')
                    ->groupBy('courses.id', 'courses.name')
                    ->orderBy('total_earnings', 'desc')  // ✅ Atur manual order
            )
            ->columns([
                Tables\Columns\TextColumn::make('course_name')->label('Kursus'),
                Tables\Columns\TextColumn::make('total_earnings')
                    ->label('Pendapatan Saya')
                    ->money('IDR')
                // ->summarize([
                //     Sum::make()->money('IDR'),
                // ]),
            ])
            ->filters([])
            ->headerActions([
                Action::make('withdraw')
                    ->label('Ajukan Pencairan')
                    ->color('success')
                    ->icon('heroicon-o-banknotes')
                    ->form([
                        Section::make('Rekening Pencairan')
                            ->schema([
                                TextInput::make('account_name')
                                    ->label('Nama Pemilik Rekening')
                                    ->required()
                                    ->maxLength(255)
                                    ->default(auth()->user()->account_name ?? null),
                                TextInput::make('account_number')
                                    ->label('Nomor Rekening')
                                    ->required()
                                    ->maxLength(50)
                                    ->default(auth()->user()->account_number ?? null),
                                TextInput::make('bank_name')
                                    ->label('Nama Bank')
                                    ->required()
                                    ->maxLength(100)
                                    ->default(auth()->user()->bank_name ?? null),
                            ]),
                        Section::make('Jumlah Pencairan')
                            ->schema([
                                TextInput::make('amount')
                                    ->label('Jumlah (Rp)')
                                    ->prefix('Rp')
                                    ->numeric()
                                    ->required()
                                    ->maxValue(function () {
                                        $totalEarned = Commission::where('mentor_id', auth()->id())->sum('amount');
                                        $totalWithdrawn = Withdrawal::where('mentor_id', auth()->id())
                                            ->where('status', 'completed')
                                            ->sum('amount');
                                        return $totalEarned - $totalWithdrawn;  // ← ini SALDO TERSEDIA
                                    })
                                    ->maxValue(function () {
                                        $totalEarned = Commission::where('mentor_id', auth()->id())->sum('amount');
                                        $totalWithdrawn = Withdrawal::where('mentor_id', auth()->id())
                                            ->where('status', 'completed')
                                            ->sum('amount');
                                        return $totalEarned - $totalWithdrawn;
                                    })
                                    ->helperText(function () {
                                        $totalEarned = Commission::where('mentor_id', auth()->id())->sum('amount');
                                        $totalWithdrawn = Withdrawal::where('mentor_id', auth()->id())
                                            ->where('status', 'completed')
                                            ->sum('amount');
                                        $available = $totalEarned - $totalWithdrawn;
                                        return 'Saldo tersedia: Rp ' . number_format($available, 0, ',', '.');
                                    }),
                            ]),
                    ])
                    ->action(function (array $data) {
                        Withdrawal::create([
                            'mentor_id' => auth()->id(),
                            'amount' => $data['amount'],
                            'account_name' => $data['account_name'],
                            'account_number' => $data['account_number'],
                            'bank_name' => $data['bank_name'],
                            'status' => 'pending',
                        ]);

                        Notification::make()
                            ->success()
                            ->title('Pencairan diajukan')
                            ->body('Permintaan pencairan sedang diproses oleh admin.')
                            ->send();
                    }),
            ])
            ->actions([])
            ->bulkActions([]);
    }

    public static function getWidgets(): array
    {
        return [
            MentorTotalEarnings::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMentorEarnings::route('/'),
        ];
    }
}
