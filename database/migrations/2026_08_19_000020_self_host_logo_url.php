<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The site logo was seeded pointing at the old WordPress site
     * (rjspharma.in/wp-content/...), an external host outside our control.
     * That dependency was the root cause of the logo intermittently
     * failing to load (e.g. the footer going blank while the nav loaded
     * fine) — the old site was flaky about serving duplicate requests for
     * the same image. The real logo file now ships as a static asset at
     * public/images/logo.png, so this repoints the already-live setting
     * at it. Only touches rows still on the old external URL, so it won't
     * clobber a logo an admin has since uploaded through the admin panel.
     */
    public function up(): void
    {
        DB::table('settings')
            ->where('key', 'logo_url')
            ->where('value', 'https://rjspharma.in/wp-content/uploads/2024/10/logo.png')
            ->update(['value' => '/images/logo.png']);
    }

    public function down(): void
    {
        DB::table('settings')
            ->where('key', 'logo_url')
            ->where('value', '/images/logo.png')
            ->update(['value' => 'https://rjspharma.in/wp-content/uploads/2024/10/logo.png']);
    }
};
