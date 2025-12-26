<?php

namespace App\Filament\Resources\EssayAssignmentResource\Pages;

use App\Filament\Resources\EssayAssignmentResource;
use App\Models\EssayAssignment;
use App\Models\EssaySubmission;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Filament\Tables;

class ViewEssaySubmissions extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = EssayAssignmentResource::class;
    protected static string $view = 'filament.resources.essay-assignment-resource.pages.view-essay-submissions';

    public EssayAssignment $record;

    public function mount(EssayAssignment $record): void
    {
        if ($record->created_by !== auth()->id()) {
            abort(403);
        }
        $this->record = $record;
    }

    public function getHeading(): string
    {
        return 'Pengumpulan: ' . $this->record->title;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(EssaySubmission::query()->where('essay_assignment_id', $this->record->id))
            ->columns([
                TextColumn::make('student.name')->label('Siswa'),
                TextColumn::make('submitted_at')
                    ->dateTime('d M Y, H:i')
                    ->toggleable(),
                TextColumn::make('submission_status')
                    ->label('Status Pengumpulan')
                    ->getStateUsing(fn(EssaySubmission $record) => $record->isLate() ? 'Terlambat' : 'Tepat Waktu')
                    ->badge()
                    ->color(fn(EssaySubmission $record) => $record->isLate() ? 'danger' : 'success')
                    ->icon(fn(EssaySubmission $record) => $record->isLate()
                        ? 'heroicon-o-clock'
                        : 'heroicon-o-check-badge')
                    ->iconPosition('before'),
                TextColumn::make('score')->numeric(),
                TextColumn::make('is_graded')->badge(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->form([
                        \Filament\Forms\Components\Textarea::make('answer_text')->disabled(),
                        \Filament\Forms\Components\TextInput::make('score')->numeric()->minValue(0)->maxValue(100),
                        \Filament\Forms\Components\Textarea::make('feedback'),
                        \Filament\Forms\Components\Toggle::make('is_graded'),
                    ]),
            ]);
    }
}
