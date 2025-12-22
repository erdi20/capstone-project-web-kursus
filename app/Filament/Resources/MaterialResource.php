<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseResource\Pages\ListCourseMaterials;
use App\Filament\Resources\MaterialResource\Pages;
use App\Filament\Resources\MaterialResource\RelationManagers;
use App\Models\Material;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MaterialResource extends Resource
{
    protected static ?string $model = Material::class;

    // 1. Ikon yang lebih spesifik dan menarik (misalnya, buku terbuka)
    protected static ?string $navigationIcon = 'heroicon-o-book-open';  // Ikon Buku Terbuka

    // 2. Mengubah label tunggal menjadi 'Materi Pembelajaran' agar lebih formal
    protected static ?string $modelLabel = 'Materi Pembelajaran';

    // 3. Mengatur label plural (digunakan di judul halaman Index)
    protected static ?string $pluralModelLabel = 'Daftar Materi';

    // 4. Mengelompokkan navigasi di bawah grup tertentu
    protected static ?string $navigationGroup = 'Akademik & Konten';

    // 5. Mengatur Urutan Navigasi (misalnya, di urutan ke-2 setelah Course)
    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        $user = auth()->user();

        // Izinkan akses jika user adalah admin atau mentor
        return $user->isMentor();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // 1. SECTION: Informasi Dasar & Relasi
                Section::make('Identifikasi dan Penempatan Materi')
                    ->description('Tentukan nama materi, urutan, dan kursus induknya.')
                    ->columns(2)
                    ->schema([
                        Hidden::make('course_id')
                            ->default(function () {
                                $courseId = app('request')->query('course_id');
                                return is_numeric($courseId) ? (int) $courseId : null;
                            }),
                        // Kolom Kiri
                        Forms\Components\TextInput::make('name')
                            ->label('Judul Materi')
                            ->placeholder('Contoh: Struktur Data dan Array')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),
                        Toggle::make('is_attendance_required')
                            ->label('Aktifkan Absensi untuk Materi Ini')
                            ->helperText('Jika diaktifkan, siswa harus absen saat mengakses materi ini.'),
                        // Di dalam form Attach/Edit action
                        Forms\Components\DateTimePicker::make('attendance_start')
                            ->label('Waktu Mulai Absen')
                            ->timezone('Asia/Jakarta')
                            ->seconds(false)
                            ->required(fn($get) => $get('is_attendance_required'))
                            ->columnSpan(1),
                        Forms\Components\DateTimePicker::make('attendance_end')
                            ->label('Waktu Selesai Absen')
                            ->timezone('Asia/Jakarta')
                            ->seconds(false)
                            ->required(fn($get) => $get('is_attendance_required'))
                            ->columnSpan(1),
                    ]),
                // ---
                // 2. SECTION: Konten Utama (Menggunakan Rich Editor)
                Section::make('Konten Teks Materi')
                    ->description('Tuliskan isi utama materi menggunakan editor kaya.')
                    ->schema([
                        // Mengganti Textarea biasa dengan RichEditor (Tiptap)
                        Forms\Components\RichEditor::make('content')
                            ->label('Isi Materi')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                // ---
                // 3. SECTION: Sumber Daya Tambahan (Grid 3 Kolom)
                Section::make('Lampiran dan Sumber Daya')
                    ->description('Unggah atau tautkan file tambahan yang relevan dengan materi ini.')
                    ->columns(3)
                    ->schema([
                        // Video Link
                        TextInput::make('link_video')
                            ->label('Tautan Video (YouTube/Vimeo)')
                            // ->url()  // Menambah validasi URL
                            ->placeholder('Masukkan URL video'),
                        // Unggah PDF
                        FileUpload::make('pdf')
                            ->label('File PDF / Dokumen')
                            ->directory('material-docs')
                            ->acceptedFileTypes(['application/pdf'])  // Hanya terima PDF
                            ->preserveFilenames(),
                        // Gambar Ilustrasi
                        FileUpload::make('image')
                            ->label('Gambar Ilustrasi')
                            ->directory('material-images')
                            ->image()
                            ->maxSize(1024)  // Maksimal 1MB
                            ->preserveFilenames()
                            ->nullable(),
                    ]),
                // 4. FIELD TERSEMBUNYI (Sistem)
                Hidden::make('created_by')
                    ->default(auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('link_video')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('pdf')
                    ->searchable(),
                Tables\Columns\TextColumn::make('course.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_by')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\Action::make('attendances')
                        ->label('Lihat Absensi')
                        ->icon('heroicon-o-calendar-days')
                        ->url(fn(Material $record) => static::getUrl('attendances', ['record' => $record->id]))
                        ->color('primary'),
                    Action::make('create_essay')
                        ->label('Buat Tugas Essay')
                        ->color('success')
                        ->icon('heroicon-o-document-text')
                        ->url(fn(Material $record): string => EssayAssignmentResource::getUrl('create') . '?material_id=' . $record->id)
                        ->openUrlInNewTab(false),  // atau true jika ingin di tab baru
                    Action::make('create_quiz')
                        ->label('Buat Tugas Quiz')
                        ->color('info')
                        ->icon('heroicon-o-clipboard-document-check')
                        ->url(fn(Material $record): string => QuizAssignmentResource::getUrl('create') . '?material_id=' . $record->id)
                        ->openUrlInNewTab(false),
                ])
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
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
            'attendances' => Pages\ViewMaterialAttendances::route('/{record}/attendances'),
        ];
    }
}
