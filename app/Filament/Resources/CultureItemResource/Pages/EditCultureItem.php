<?php

namespace App\Filament\Resources\CultureItemResource\Pages;

use App\Filament\Resources\CultureItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCultureItem extends EditRecord
{
    protected static string $resource = CultureItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
