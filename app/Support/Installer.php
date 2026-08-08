<?php

namespace App\Support;

class Installer
{
    public static function lockPath(): string
    {
        return storage_path('app/installed.flag');
    }

    public static function isInstalled(): bool
    {
        return file_exists(static::lockPath());
    }

    public static function markInstalled(): void
    {
        file_put_contents(static::lockPath(), now()->toDateTimeString());
    }
}
