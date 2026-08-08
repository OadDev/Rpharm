<?php

namespace App\Filament\Resources\ValuePropResource\Pages;

use App\Filament\Resources\ValuePropResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditValueProp extends EditRecord
{
    protected static string $resource = ValuePropResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
