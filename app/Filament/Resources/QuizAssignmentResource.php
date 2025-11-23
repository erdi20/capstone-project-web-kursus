<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizAssignmentResource\Pages\CreateQuizAssignment;
use App\Filament\Resources\QuizAssignmentResource\Pages\EditQuizAssignment;
use App\Filament\Resources\QuizAssignmentResource\Pages\ListQuizAssignments;
use App\Filament\Resources\QuizAssignmentResource\RelationManagers\QuestionsRelationManager;
use App\Filament\Resources\QuizAssignmentResource\Pages;
use App\Filament\Resources\QuizAssignmentResource\RelationManagers;
use App\Models\QuizAssignment;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizAssignmentResource extends Resource
{
    protected static ?string $model = QuizAssignment::class;

    protected static ?string $modelLabel = 'Penugasan Kuis';

    protected static ?string $pluralModelLabel = 'Manajemen Kuis';

    protected static ?string $navigationIcon = 'heroicon-o-document-check';  // Ikon yang lebih relevan

    protected static ?string $navigationGroup = 'Manajemen Kursus';

    protected static ?int $navigationSort = 2;  // Urutan setelah Tugas Esai (jika Esai = 3)

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Dasar Kuis')
                    ->description('Tentukan judul, kelas, dan instruksi dasar untuk kuis ini.')
                    ->columns(2)
                    ->schema([
                        Select::make('course_class_id')
                            ->label('Kelas Tujuan')
                            ->relationship('courseClass', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('title')
                            ->label('Judul Kuis')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Kuis Akhir Bab 3 - Struktur Data'),
                    ]),
                Section::make('Instruksi Kuis')
                    ->schema([
                        RichEditor::make('description')
                            ->label('Instruksi Lengkap')
                            ->helperText('Berikan instruksi jelas mengenai materi dan peraturan kuis.')
                            ->columnSpanFull()
                    ]),
                Section::make('Pengaturan Waktu')
                    ->columns(3)
                    ->schema([
                        DateTimePicker::make('due_date')
                            ->label('Batas Waktu Pengumpulan')
                            ->minDate(now())
                            ->required()
                            ->columnSpan(2),
                        TextInput::make('duration_minutes')
                            ->label('Durasi Kuis (Menit)')
                            ->helperText('Kosongkan jika kuis tidak memiliki batas waktu pengerjaan.')
                            ->numeric()
                            ->minValue(5)
                            ->suffix('Menit'),
                    ]),
                Fieldset::make('Opsi Publikasi')
                    ->columns(3)
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Publikasikan Kuis')
                            ->helperText('Jika aktif, kuis akan terlihat oleh siswa di Kelas Tujuan.')
                            ->default(false)
                            ->columnSpan(1),
                        Hidden::make('created_by')
                            ->default(auth()->id()),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('courseClass.name')
                    ->label('Kelas Tujuan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')  // Menonjolkan kelas
                    ->color('primary'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Kuis')
                    ->searchable()
                    ->wrap()
                    ->limit(40),
                Tables\Columns\TextColumn::make('duration_minutes')
                    ->label('Durasi')
                    ->formatStateUsing(fn($state) => $state ? "{$state} Menit" : 'Tanpa Batas')
                    ->sortable()
                    ->description(fn($record) => $record->questions()->count() . ' Soal'),  // Menampilkan jumlah soal
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Batas Waktu')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->color(fn(string $state): string => match (true) {
                        now()->gt($state) => 'danger',  // Merah jika sudah melewati deadline
                        now()->diffInHours($state) <= 48 => 'warning',  // Kuning jika mendekati deadline (48 jam)
                        default => 'success',
                    }),
                Tables\Columns\BadgeColumn::make('is_published')
                    ->label('Status')
                    ->sortable()
                    ->getStateUsing(fn($record): string => $record->is_published ? 'Aktif' : 'Draf')
                    ->colors([
                        'success' => 'Aktif',
                        'warning' => 'Draf',
                    ]),
                // 6. Dibuat Oleh (Menggunakan Relasi Nama)
                Tables\Columns\TextColumn::make('creator.name')  // Asumsi relasi 'creator' ada ke Model User
                    ->label('Instruktur')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                // 7. Waktu Pembuatan (Hidden by default)
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Tanggal')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // 1. Filter Publikasi (Ternary Filter)
                TernaryFilter::make('is_published')
                    ->label('Status Kuis')
                    ->trueLabel('Aktif')
                    ->falseLabel('Draf')
                    ->nullable(),
                // 2. Filter Kelas Tujuan (Select Filter Relasi)
                SelectFilter::make('course_class_id')
                    ->label('Filter Berdasarkan Kelas')
                    ->relationship('courseClass', 'name')
                    ->searchable()
                    ->preload(),
                // 3. Filter Deadline (Custom Query Filter)
                Tables\Filters\Filter::make('deadline_lewat')
                    ->label('Deadline Terlewat')
                    ->query(fn(Builder $query): Builder => $query->where('due_date', '<', now()))
                    ->toggle(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            QuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizAssignments::route('/'),
            'create' => Pages\CreateQuizAssignment::route('/create'),
            'edit' => Pages\EditQuizAssignment::route('/{record}/edit'),
        ];
    }
}
