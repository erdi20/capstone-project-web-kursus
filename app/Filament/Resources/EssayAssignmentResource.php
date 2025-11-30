<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EssayAssignmentResource\RelationManagers\SubmissionsRelationManager;
use App\Filament\Resources\EssayAssignmentResource\Pages;
use App\Filament\Resources\EssayAssignmentResource\RelationManagers;
use App\Models\EssayAssignment;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Filament\Forms;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EssayAssignmentResource extends Resource
{
    protected static ?string $model = EssayAssignment::class;

    protected static ?string $modelLabel = 'Tugas Essay';  // Label untuk satu item (singular)

    protected static ?string $pluralModelLabel = 'Manajemen Tugas Essay';  // Label untuk daftar/halaman (plural)

    protected static ?string $navigationIcon = 'heroicon-o-pencil-square';  // Ikon yang lebih relevan untuk tugas esai

    protected static ?string $navigationGroup = 'Manajemen Kursus';  // Pengelompokan (Grouping) navigasi

    protected static ?int $navigationSort = 1;  // Menentukan urutan di dalam group (opsional)

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Dasar Tugas')
                    ->description('Tentukan kelas tujuan, judul, dan batas waktu pengumpulan.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->label('Judul Tugas')
                            ->required()
                            ->maxLength(255)
                            ->autofocus()
                            ->columnSpanFull()
                            ->placeholder('Contoh: Analisis Kebutuhan Sistem'),
                        Select::make('course_class_id')
                            ->label('Kelas Tujuan')
                            ->relationship('courseClass', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live(),  // untuk trigger dependensi jika diperlukan
                        DateTimePicker::make('due_date')
                            ->label('Batas Waktu Pengumpulan')
                            ->required()
                            ->minDate(now()->addHour())
                            ->closeOnDateSelection()
                            ->native(false),
                    ]),
                Section::make('Instruksi dan Lampiran')
                    ->description('Berikan instruksi lengkap dan file pendukung jika diperlukan.')
                    ->schema([
                        RichEditor::make('description')
                            ->label('Instruksi Tugas')
                            ->required()
                            ->columnSpanFull()
                            ->fileAttachmentsDirectory('assignments/attachments')
                            ->placeholder('Jelaskan secara rinci apa yang harus dikerjakan oleh peserta...'),
                        FileUpload::make('attachment')
                            ->label('Lampiran File Pendukung (Opsional)')
                            ->disk('public')
                            ->directory('assignments/attachments')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->maxSize(10240)  // 10 MB
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/*'])
                            ->helperText('Format: PDF, DOC, DOCX, atau gambar. Maks. 10 MB.'),
                    ]),
                Section::make('Pengaturan Pengumpulan')
                    ->description('Atur cara peserta mengumpulkan tugas dan kapan tugas dipublikasikan.')
                    ->columns(2)
                    ->schema([
                        Toggle::make('is_published')
                            ->label('Publikasikan segera')
                            ->default(true)
                            ->helperText('Jika dimatikan, tugas tidak akan terlihat oleh peserta.'),
                        Toggle::make('allow_file_upload')
                            ->label('Izinkan unggah file')
                            ->default(true)
                            ->helperText('Jika dimatikan, peserta hanya bisa menulis jawaban teks.'),
                        TextInput::make('word_limit')
                            ->label('Batas kata (opsional)')
                            ->numeric()
                            ->minValue(10)
                            ->maxValue(10000)
                            ->helperText('Contoh: 500. Biarkan kosong jika tidak dibatasi.')
                            ->visible(fn(callable $get) => !$get('allow_file_upload')),
                    ]),
                Hidden::make('created_by')
                    ->default(fn() => auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // 1. Kelas Tujuan (Menggunakan Relasi Nama)
                Tables\Columns\TextColumn::make('courseClass.name')  // Asumsi relasi 'courseClass' ada
                    ->label('Kelas Tujuan')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                // 2. Judul Tugas
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Tugas')
                    ->searchable()
                    ->limit(50)  // Batasi panjang teks agar tabel rapi
                    ->wrap(),
                // 3. Status Publikasi (Menggunakan Badge/Icon + Badge jika belum deadline)
                Tables\Columns\BadgeColumn::make('is_published')
                    ->label('Status Publikasi')
                    ->sortable()
                    ->getStateUsing(fn($record): string => $record->is_published ? 'Terpublikasi' : 'Draf')
                    ->colors([
                        'success' => 'Terpublikasi',
                        'warning' => 'Draf',
                    ]),
                // 4. Batas Waktu (Dengan Warna Visual untuk Deadline)
                Tables\Columns\TextColumn::make('due_date')
                    ->label('Batas Waktu')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->color(fn(string $state): string => match (true) {
                        now()->gt($state) => 'danger',  // Merah jika sudah melewati deadline
                        now()->diffInDays($state) <= 2 => 'warning',  // Kuning jika mendekati deadline (2 hari)
                        default => 'success',  // Hijau jika masih lama
                    }),
                // 5. Izin Upload File (Icon)
                Tables\Columns\IconColumn::make('allow_file_upload')
                    ->label('Izin Upload')
                    ->boolean()
                    ->sortable(),
                // 6. Dibuat Oleh (Menggunakan Relasi Nama)
                Tables\Columns\TextColumn::make('creator.name')  // Asumsi relasi 'creator' ada ke Model User
                    ->label('Dibuat Oleh')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),  // Sembunyikan secara default
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
                    ->label('Status Publikasi')
                    ->trueLabel('Terpublikasi')
                    ->falseLabel('Draf')
                    ->nullable(),
                // 2. Filter Kelas Tujuan (Select Filter Relasi)
                SelectFilter::make('course_class_id')
                    ->label('Filter Berdasarkan Kelas')
                    ->relationship('courseClass', 'name')  // Menggunakan relasi
                    ->searchable()
                    ->preload(),
                // 3. Filter Deadline (Custom Query Filter)
                Tables\Filters\Filter::make('deadline_lewat')
                    ->label('Deadline Terlewat')
                    ->query(fn(Builder $query): Builder => $query->where('due_date', '<', now()))
                    ->toggle()  // Tampilkan sebagai toggle button
                    ->default(false),  // Tidak aktif secara default
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('submissions')
                    ->label('Lihat Pengumpulan')
                    ->url(fn(EssayAssignment $record): string => static::getUrl('submissions', ['record' => $record->id]))
                    ->button()
                    ->color('info'),
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
            SubmissionsRelationManager::class,
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('created_by', auth()->id());  // hanya tugas yang dibuat oleh user ini
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEssayAssignments::route('/'),
            'create' => Pages\CreateEssayAssignment::route('/create'),
            'edit' => Pages\EditEssayAssignment::route('/{record}/edit'),
            'submissions' => Pages\ViewEssaySubmissions::route('/{record}/submissions'),  // ← tambahkan ini
        ];
    }
}
