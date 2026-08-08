<?php

namespace App\Filament\Resources\UspItemResource\Pages;

use App\Filament\Resources\UspItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUspItems extends ListRecords
{
    protected static string $resource = UspItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
