<?php

namespace App\Filament\Resources\CourseResource\RelationManagers;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Closure;

class ClassesRelationManager extends RelationManager
{
    protected static string $relationship = 'classes';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Kelas')
                    ->description('Isi nama dan deskripsi sesi kelas ini.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Sesi Kelas')
                            ->placeholder('Contoh: Sesi 1: Pengenalan PHP dan Laravel')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),
                        RichEditor::make('description')
                            ->label('Deskripsi Sesi Kelas')
                            ->placeholder('Jelaskan materi yang akan dibahas...')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'strike',
                                'heading',
                                'undo',
                                'redo',
                                'bulletList',
                                'orderedList',
                                'link',
                            ])
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('Pengaturan Teknis & Jadwal Pendaftaran')
                    ->columns(['default' => 1, 'lg' => 3])
                    ->schema([
                        TextInput::make('max_quota')
                            ->label('Kuota Maksimum Peserta')
                            ->required()
                            ->numeric()
                            ->minValue(1),
                        Group::make()
                            ->columnSpan(2)
                            ->columns(2)
                            ->schema([
                                DateTimePicker::make('enrollment_start')
                                    ->label('Mulai Pendaftaran')
                                    ->required()
                                    ->live(onBlur: true),
                                DateTimePicker::make('enrollment_end')
                                    ->label('Akhir Pendaftaran')
                                    ->required()
                                    ->minDate(fn(Get $get) => $get('enrollment_start') ?? now())
                                    ->rule(fn(Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                        $start = $get('enrollment_start');
                                        if ($start && $value && $value <= $start) {
                                            $fail('Akhir Pendaftaran harus setelah Mulai Pendaftaran.');
                                        }
                                    }),
                            ]),
                    ]),
                Section::make('Status Kelas')
                    ->schema([
                        Select::make('status')
                            ->label('Status Kelas')
                            ->options([
                                'draft' => 'Draft (Belum Ditampilkan/Diuji)',
                                'open' => 'Open (Pendaftaran Dibuka)',
                                'closed' => 'Closed (Pendaftaran Ditutup/Selesai)',
                                'archived' => 'Archived (Diarsipkan)',
                            ])
                            ->default('draft')
                            ->required(),
                    ]),
                // ✅ Isi otomatis
                Hidden::make('course_id')
                    ->default(fn($livewire) => $livewire->ownerRecord->id),
                Hidden::make('created_by')
                    ->default(auth()->id()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'draft' => 'gray',
                        'open' => 'success',
                        'closed' => 'warning',
                        'archived' => 'danger',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('max_quota')
                    ->label('Kuota')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('createdBy.name')
                    ->label('Dibuat Oleh')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
