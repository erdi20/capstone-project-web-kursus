<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseClassResource\RelationManagers\MaterialsRelationManager;
use App\Filament\Resources\CourseClassResource\Pages;
use App\Filament\Resources\CourseClassResource\RelationManagers;
use App\Models\CourseClass;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseClassResource extends Resource
{
    protected static ?string $model = CourseClass::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';  // Ikon kalender atau daftar (sesuai Kelas/Jadwal)

    protected static ?string $modelLabel = 'Kelas';

    protected static ?string $pluralModelLabel = 'Kelas';

    protected static ?string $navigationGroup = 'Akademik & Konten';

    protected static ?int $navigationSort = 1;  // Urutan sebelum Materi (2)

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Kelas dan Kursus Induk')
                    ->description('Pilih kursus induk dan berikan nama serta deskripsi sesi kelas ini.')
                    ->schema([
                        Select::make('course_id')
                            ->label('Kursus Induk')
                            ->relationship('course', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Sesi Kelas')
                            ->placeholder('Contoh: Sesi 1: Pengenalan PHP dan Laravel')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Sesi Kelas')
                            ->placeholder('Jelaskan materi yang akan dibahas pada sesi kelas ini.')
                            ->rows(4)
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('Pengaturan Teknis dan Publikasi')
                    ->description('Atur kuota peserta dan status publikasi kelas.')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('max_quota')
                            ->label('Kuota Maksimum Peserta')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->inputMode('numeric'),
                        Select::make('status')
                            ->label('Status Kelas')
                            ->options([
                                'draft' => 'Draft (Belum Ditampilkan)',
                                'open' => 'Open (Dibuka untuk Pendaftaran)',
                                'closed' => 'Closed (Kuota Penuh/Selesai)',
                                'archived' => 'Archived (Diarsipkan)',
                            ])
                            ->default('draft')
                            ->required(),
                        Hidden::make('created_by')
                            ->default(auth()->id()),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Kelas')
                    ->searchable()
                    ->sortable()
                    ->limit(35),
                TextColumn::make('course.name')
                    ->label('Kursus Induk')
                    ->sortable()
                    ->searchable(),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'open',
                        'danger' => 'closed',
                        'info' => 'archived',
                    ]),
                TextColumn::make('max_quota')
                    ->label('Kuota Maks.')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('createdBy.name')
                    ->label('Mentor')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            MaterialsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourseClasses::route('/'),
            'create' => Pages\CreateCourseClass::route('/create'),
            'edit' => Pages\EditCourseClass::route('/{record}/edit'),
        ];
    }
}
