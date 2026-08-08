<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobApplicationResource\Pages;
use App\Models\JobApplication;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class JobApplicationResource extends Resource
{
    protected static ?string $model = JobApplication::class;

    protected static ?string $navigationIcon = 'heroicon-o-inbox-arrow-down';

    protected static ?string $navigationGroup = 'Recruitment';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('job_opening_id')
                    ->relationship('jobOpening', 'title')
                    ->disabled(),
                Forms\Components\TextInput::make('full_name')
                    ->disabled(),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->disabled(),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->disabled(),
                Forms\Components\TextInput::make('position')
                    ->disabled(),
                Forms\Components\Textarea::make('cover_note')
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('cv_original_name')
                    ->label('CV file')
                    ->disabled(),
                Forms\Components\Select::make('status')
                    ->options([
                        'new' => 'New',
                        'reviewed' => 'Reviewed',
                        'shortlisted' => 'Shortlisted',
                        'rejected' => 'Rejected',
                        'hired' => 'Hired',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Applied')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('position')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'info',
                        'reviewed' => 'warning',
                        'shortlisted' => 'primary',
                        'hired' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'reviewed' => 'Reviewed',
                        'shortlisted' => 'Shortlisted',
                        'rejected' => 'Rejected',
                        'hired' => 'Hired',
                    ]),
                Tables\Filters\SelectFilter::make('position')
                    ->relationship('jobOpening', 'title'),
            ])
            ->actions([
                Tables\Actions\Action::make('download_cv')
                    ->label('Download CV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(fn (JobApplication $record) => Storage::disk('local')->download($record->cv_path, $record->cv_original_name))
                    ->visible(fn (JobApplication $record) => Storage::disk('local')->exists($record->cv_path)),
                Tables\Actions\EditAction::make()
                    ->label('Update status'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getModel()::where('status', 'new')->count();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobApplications::route('/'),
            'edit' => Pages\EditJobApplication::route('/{record}/edit'),
        ];
    }
}
