<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\CourseClass;
use App\Services\GradingService;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\CourseClassResource\Pages;
use App\Filament\Resources\CourseClassResource\RelationManagers;
use App\Filament\Resources\CourseClassResource\RelationManagers\MaterialsRelationManager;

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
                // Kolom utama untuk tata letak 2 kolom besar di desktop
                Section::make('Detail Kelas & Kursus Induk')
                    ->description('Pilih kursus induk, nama, dan deskripsi sesi kelas ini.')
                    ->schema([
                        // Grup untuk Kursus Induk dan Nama Kelas (Horizontal)
                        Group::make()
                            ->columns(2)
                            ->schema([
                                FileUpload::make('thumbnail')
                                    ->label('Foto Kelas (Thumbnail)')
                                    ->disk('public')
                                    ->directory('class-thumbnails')
                                    ->image()
                                    ->imageEditor()
                                    ->required(false)
                                    ->helperText('Unggah gambar representatif untuk kelas ini (misal: ilustrasi sesi, grup belajar, dll.)'),
                                Select::make('course_id')
                                    ->label('Kursus Induk')
                                    ->relationship('course', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->helperText('Kelas ini akan berada di bawah kursus utama yang dipilih.'),
                                TextInput::make('name')
                                    ->label('Nama Sesi Kelas')
                                    ->placeholder('Contoh: Sesi 1: Pengenalan PHP dan Laravel')
                                    ->required()
                                    ->maxLength(255)
                                    ->autofocus(),
                            ]),
                        // Deskripsi Kelas (Full Column Span)
                        RichEditor::make('description')  // Menggunakan RichEditor
                            ->label('Deskripsi Sesi Kelas')
                            ->placeholder('Jelaskan materi yang akan dibahas, tujuan, dan prasyarat pada sesi kelas ini.')
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
                // Bagian Pengaturan Teknis dan Publikasi
                Section::make('Pengaturan Teknis & Jadwal Pendaftaran')
                    ->description('Atur kuota peserta, periode pendaftaran, dan status kelas.')
                    ->columns([
                        'default' => 1,
                        'lg' => 3,  // Menggunakan 3 kolom
                    ])
                    ->schema([
                        // Field 1: Kuota Maksimum
                        TextInput::make('max_quota')
                            ->label('Kuota Maksimum Peserta')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->inputMode('numeric')
                            ->helperText('Jumlah maksimum peserta yang dapat mendaftar.'),
                        // Field 2 & 3: Periode Pendaftaran (Dikelompokkan secara visual)
                        Group::make()
                            ->columnSpan(2)  // Mengambil 2 kolom dari 3 kolom
                            ->columns(2)
                            ->schema([
                                // Pastikan tidak ada konflik seconds()
                                DateTimePicker::make('enrollment_start')
                                    ->label('Mulai Pendaftaran')
                                    // Coba hapus ->seconds(false) atau set ke true
                                    ->seconds(true)  // <-- UBAH KE TRUE ATAU HAPUS SAJA
                                    ->required()
                                    ->live(onBlur: true),
                                DateTimePicker::make('enrollment_end')
                                    ->label('Akhir Pendaftaran')
                                    // Coba hapus ->seconds(false) atau set ke true
                                    ->seconds(true)  // <-- UBAH KE TRUE ATAU HAPUS SAJA
                                    ->required()
                                    ->minDate(fn(Get $get) => $get('enrollment_start') ?? now())
                                    // Rule validasi tetap dipertahankan
                                    ->rule(fn(Get $get, $state): Closure => function (string $attribute, $value, Closure $fail) use ($get) {
                                        $start = $get('enrollment_start');
                                        if ($start && $value && $value <= $start) {
                                            $fail('Akhir Pendaftaran harus setelah Mulai Pendaftaran.');
                                        }
                                    }),
                            ]),
                    ]),
                // Bagian Status Publikasi (Dapat dipisah ke Section sendiri jika banyak pengaturan)
                Section::make('Status Kelas')
                    ->columns(1)
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
                            ->required()
                            ->helperText('Atur apakah kelas ini siap untuk didaftarkan oleh peserta.'),
                    ]),
                Hidden::make('created_by')
                    ->default(auth()->id()),
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
                ActionGroup::make([
                    Tables\Actions\EditAction::make()
                        ->icon('heroicon-o-pencil'),
                    Tables\Actions\Action::make('attendances')
                        ->label('Lihat Absensi')
                        ->icon('heroicon-o-calendar-days')
                        ->url(fn(\App\Models\CourseClass $record) => static::getUrl('attendances', ['record' => $record->id]))
                        ->color('primary'),
                    Tables\Actions\Action::make('students')
                        ->label('Lihat Siswa')
                        ->icon('heroicon-o-users')
                        ->url(fn(\App\Models\CourseClass $record) => static::getUrl('students', ['record' => $record->id]))
                        ->color('info'),
                    Tables\Actions\Action::make('recalculate_grades')
                        ->label('Hitung Ulang Semua Nilai')
                        ->icon('heroicon-o-arrow-path')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(function (CourseClass $record) {
                            $enrollments = $record->enrollments()->get();

                            if ($enrollments->isEmpty()) {
                                \Filament\Notifications\Notification::make()
                                    ->title('Tidak ada siswa terdaftar di kelas ini')
                                    ->warning()
                                    ->send();
                                return;
                            }

                            $service = app(GradingService::class);

                            foreach ($enrollments as $enrollment) {
                                $service->updateEnrollmentGrade($enrollment);
                            }

                            \Filament\Notifications\Notification::make()
                                ->title('Nilai berhasil dihitung ulang untuk ' . $enrollments->count() . ' siswa')
                                ->success()
                                ->send();
                        }),
                    Tables\Actions\DeleteAction::make()
                        ->icon('heroicon-o-trash')
                        ->color('danger'),
                ])
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->tooltip('Tindakan Lanjutan'),
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

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('created_by', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourseClasses::route('/'),
            'create' => Pages\CreateCourseClass::route('/create'),
            'edit' => Pages\EditCourseClass::route('/{record}/edit'),
            'attendances' => Pages\ViewClassAttendances::route('/{record}/attendances'),
            'students' => Pages\ViewClassStudents::route('/{record}/students'),
        ];
    }
}
