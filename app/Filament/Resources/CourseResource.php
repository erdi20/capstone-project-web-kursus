<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';  // Ikon Topi Akademik

    // 2. Mengubah label tunggal
    protected static ?string $modelLabel = 'Program Kursus';

    // 3. Mengatur label plural
    protected static ?string $pluralModelLabel = 'Daftar Program Kursus';

    // 4. Mengelompokkan navigasi di bawah grup yang sama
    protected static ?string $navigationGroup = 'Akademik & Konten';

    // 5. Mengatur Urutan Navigasi menjadi yang paling atas (0)
    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Utama Kursus')
                    ->description('Detail dasar seperti nama, deskripsi, dan harga kursus.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Kursus')
                            ->placeholder('Contoh: Full Stack Laravel Development')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),
                        Grid::make(2)
                            ->schema([
                                FileUpload::make('thumbnail')
                                    ->label('Thumbnail Kursus (Gambar Sampul)')
                                    // ->disk('public')
                                    ->directory('course-thumbnails')
                                    ->image()
                                    ->required(),
                                Forms\Components\TextInput::make('price')
                                    ->label('Harga Kursus')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->inputMode('decimal'),
                            ]),
                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Singkat Kursus')
                            ->placeholder('Jelaskan secara singkat manfaat dan fokus utama kursus ini.')
                            ->rows(5)
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('Pengaturan Pendaftaran (Enrollment) dan Status')
                    ->description('Atur kapan kursus ini dibuka untuk pendaftaran dan status publikasi.')
                    ->columns(3)
                    ->schema([
                        Select::make('status')
                            ->label('Status Publikasi')
                            ->options([
                                'draft' => 'Draft',
                                'open' => 'Dibuka',
                                'closed' => 'Tutup',
                                'archived' => 'Diarsipkan',
                            ])
                            ->default('draft')
                            ->required(),
                        DateTimePicker::make('enrollment_start')
                            ->label('Mulai Pendaftaran')
                            ->placeholder('Pilih tanggal dan waktu')
                            ->seconds(false)
                            ->required(),
                        DateTimePicker::make('enrollment_end')
                            ->label('Akhir Pendaftaran')
                            ->placeholder('Pilih tanggal dan waktu')
                            ->seconds(false)
                            ->required(),
                    ]),
                Hidden::make('created_by')
                    ->default(auth()->id()),  // Asumsi Anda menggunakan autentikasi default Laravel
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Sampul')
                    ->square()
                    ->size(40),
                TextColumn::make('name')
                    ->label('Nama Kursus')
                    ->searchable()
                    ->sortable()
                    ->limit(35),
                SelectColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->options([
                        'draft' => 'Draft',
                        'open' => 'Dibuka',
                        'closed' => 'Tutup',
                        'archived' => 'Diarsipkan',
                    ]),
                TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                TextColumn::make('createdBy.name')
                    ->label('Mentor (Dibuat Oleh)')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('enrollment_start')
                    ->label('Mulai Pendaftaran')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->date('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
