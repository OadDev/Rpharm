<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSetting extends CreateRecord
{
    protected static string $resource = SettingResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (($data['key'] ?? null) === 'logo_url') {
            $data['value'] = $data['logo'] ?? null;
        }

        unset($data['logo']);

        return $data;
    }
}
