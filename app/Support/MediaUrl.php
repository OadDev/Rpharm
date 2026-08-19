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

        // A root-relative path (e.g. /images/logo.png) points at a static
        // asset shipped in public/ rather than something uploaded to the
        // storage disk — return it as-is, browser resolves it against the
        // current host automatically.
        if (Str::startsWith($value, '/')) {
            return $value;
        }

        $diskUrl = Storage::disk('public')->url($value);

        // Storage::url() builds its host from the filesystems 'public' disk
        // config, which is set from APP_URL at boot — not from the current
        // request. If APP_URL ever drifts from the real serving host (moved
        // domain, http vs https, or simply stale), every uploaded image
        // (logo, product photo, testimonial avatar) would silently 404
        // while ordinary page links stay correct via URL::forceRootUrl().
        // Rebuilding from the live request host keeps the two in sync.
        if (app()->runningInConsole() || ! request()) {
            return $diskUrl;
        }

        $storageIndex = strpos($diskUrl, '/storage/');
        $relative = $storageIndex !== false ? substr($diskUrl, $storageIndex) : '/storage/'.ltrim($value, '/');

        return rtrim(request()->getSchemeAndHttpHost(), '/').$relative;
    }
}
