<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages;
use App\Filament\Resources\CourseResource\RelationManagers;
use App\Models\Course;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Closure;

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
                Section::make('Detail Dasar Kursus')
                    ->description('Nama, deskripsi, slug URL, dan gambar sampul kursus.')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Group::make()
                            ->columns(1)
                            ->columnSpan(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label('Nama Kursus')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                                TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->helperText('Slug akan otomatis terisi. Ubah hanya jika diperlukan.')
                                    ->required()
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                            ]),
                        FileUpload::make('thumbnail')
                            ->label('Thumbnail Kursus')
                            ->helperText('Gambar sampul yang menarik untuk kursus Anda.')
                            ->disk('public')
                            ->directory('course-thumbnails')
                            ->image()
                            ->imageEditor()
                            ->required()
                            ->columnSpan(1),
                        RichEditor::make('description')
                            ->label('Deskripsi Lengkap Kursus')
                            ->placeholder('Jelaskan manfaat, kurikulum, dan siapa target kursus ini.')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                Section::make('Harga & Promosi (Diskon)')
                    ->description('Tentukan harga dasar dan aktifkan promosi dengan harga diskon serta batas waktu.')
                    ->columns(3)
                    ->schema([
                        TextInput::make('price')
                            ->label('Harga Dasar (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->minValue(0)
                            ->columnSpan(1),
                        TextInput::make('discount_price')
                            ->label('Harga Diskon (Rp)')
                            ->helperText('Kosongkan jika tidak ada diskon.')
                            ->numeric()
                            ->prefix('Rp')
                            ->nullable()
                            ->rule(fn(Get $get, $state): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                $price = $get('price');
                                if ($value !== null && $price !== null && $value >= $price) {
                                    $fail("Harga diskon harus lebih rendah dari Harga Dasar (Rp {$price}).");
                                }
                            })
                            ->columnSpan(1),
                        DateTimePicker::make('discount_end_date')
                            ->label('Diskon Berakhir Pada')
                            ->helperText('Tanggal dan waktu diskon akan berakhir. Diperlukan jika Harga Diskon diisi.')
                            ->nullable()
                            ->minDate(now())
                            ->columnSpan(1)
                            ->rules([
                                fn(Get $get): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                    if ($get('discount_price') !== null && $value === null) {
                                        $fail('Tanggal berakhir diskon wajib diisi jika Harga Diskon ditetapkan.');
                                    }
                                },
                            ]),
                    ]),
                Section::make('Pengaturan Pendaftaran & Status')
                    ->description('Kapan kursus dibuka/ditutup dan status publikasinya.')
                    ->columns(3)
                    ->schema([
                        Select::make('status')
                            ->label('Status Kursus')
                            ->options([
                                'draft' => 'Draft',
                                'open' => 'Dibuka (Siap Pendaftaran)',
                                'closed' => 'Tutup Pendaftaran',
                                'archived' => 'Diarsipkan',
                            ])
                            ->default('draft')
                            ->required(),
                        DateTimePicker::make('enrollment_start')
                            ->label('Mulai Pendaftaran')
                            ->placeholder('Tanggal Mulai Pendaftaran')
                            ->seconds(false)
                            ->required(),
                        DateTimePicker::make('enrollment_end')
                            ->label('Akhir Pendaftaran')
                            ->placeholder('Tanggal Akhir Pendaftaran')
                            ->seconds(false)
                            ->required(),
                    ]),
                Hidden::make('created_by')
                    ->default(auth()->id()),
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
                    ->limit(35)
                    ->weight('bold'),
                BadgeColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'open',
                        'danger' => 'closed',
                        'secondary' => 'archived',
                    ]),
                TextColumn::make('price_display')
                    ->label('Harga Jual')
                    ->getStateUsing(function (Model $record) {
                        $isDiscountActive =
                            $record->discount_price !== null &&
                            ($record->discount_end_date === null || now()->lessThan($record->discount_end_date));

                        if ($isDiscountActive) {
                            return $record->discount_price;
                        }
                        return $record->price;
                    })
                    ->money('IDR')
                    ->color(fn(Model $record) =>
                        ($record->discount_price !== null && now()->lessThan($record->discount_end_date ?? now()->addDay())) ? 'danger' : 'success')  // Warna Merah jika diskon aktif
                    ->description(function (Model $record) {
                        $isDiscountActive =
                            $record->discount_price !== null &&
                            ($record->discount_end_date === null || now()->lessThan($record->discount_end_date));

                        if ($isDiscountActive) {
                            return 'Harga Normal: Rp' . number_format($record->price, 0, ',', '.');
                        }
                        return null;
                    })
                    ->sortable(),
                TextColumn::make('classes_count')
                    ->label('Jml. Kelas')
                    ->counts('classes')
                    ->alignCenter()
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('createdBy.name')
                    ->label('Mentor')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('enrollment_start')
                    ->label('Pendaftaran')
                    ->date('d M Y')
                    ->sortable()
                    ->description(fn(Model $record): string => 'Akhir: ' . \Carbon\Carbon::parse($record->enrollment_end)->format('d M Y'))
                    ->toggleable(),
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
