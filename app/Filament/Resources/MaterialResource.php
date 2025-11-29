<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaterialResource\Pages;
use App\Filament\Resources\MaterialResource\RelationManagers;
use App\Models\Material;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // 1. SECTION: Informasi Dasar & Relasi
                Section::make('Identifikasi dan Penempatan Materi')
                    ->description('Tentukan nama materi, urutan, dan kursus induknya.')
                    ->columns(2)
                    ->schema([
                        // Kolom Kiri
                        Forms\Components\TextInput::make('name')
                            ->label('Judul Materi')
                            ->placeholder('Contoh: Struktur Data dan Array')
                            ->required()
                            ->maxLength(255)
                            ->autofocus(),
                        // Kolom Kanan
                        Select::make('course_id')
                            ->label('Relasi Kursus Induk')
                            ->relationship('course', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                    ]),
                // ---
                // 2. SECTION: Konten Utama (Menggunakan Rich Editor)
                Section::make('Konten Teks Materi')
                    ->description('Tuliskan isi utama materi menggunakan editor kaya.')
                    ->schema([
                        // Mengganti Textarea biasa dengan RichEditor (Tiptap)
                        Forms\Components\RichEditor::make('content')
                            ->label('Isi Materi')
                            // ->toolbar([
                            //     'heading',
                            //     'bold',
                            //     'italic',
                            //     'strike',
                            //     'blockquote',
                            //     'hr',
                            //     '|',
                            //     'bulletList',
                            //     'orderedList',
                            //     '|',
                            //     'link',
                            //     'code',
                            //     'codeBlock',
                            // ])
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
            'index' => Pages\ListMaterials::route('/'),
            'create' => Pages\CreateMaterial::route('/create'),
            'edit' => Pages\EditMaterial::route('/{record}/edit'),
        ];
    }
}
