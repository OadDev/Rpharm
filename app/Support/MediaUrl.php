<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaUrl
{
    /**
     * Resolve a stored value to a usable <img src>. Accepts either a full
     * external URL (legacy seeded content, or anything an admin pastes
     * directly) or a path on the "public" disk (from a Filament FileUpload
     * field), and returns whichever applies.
     */
    public static function resolve(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        if (Str::startsWith($value, ['http://', 'https://', '//'])) {
            return $value;
        }

        return Storage::disk('public')->url($value);
    }
}
