<?php

namespace App\Filament\Resources\CultureItemResource\Pages;

use App\Filament\Resources\CultureItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCultureItems extends ListRecords
{
    protected static string $resource = CultureItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
