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
            $data['value'] = $data['logo_file'] ?? null;
        }

        unset($data['logo_file']);

        return $data;
    }
}
