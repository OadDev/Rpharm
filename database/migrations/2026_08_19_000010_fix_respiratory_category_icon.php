<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * The lung emoji (🫁) seeded for the Respiratory & Allergy category
     * doesn't render on older devices/fonts (renders as a blank box), so
     * it appeared to be "missing" on the home page and admin panel. This
     * data fix runs on already-installed sites too, since RunPendingMigrations
     * applies every new migration file, not just schema changes.
     */
    public function up(): void
    {
        DB::table('categories')
            ->where('slug', 'respiratory')
            ->update(['icon' => '🩺']);
    }

    public function down(): void
    {
        DB::table('categories')
            ->where('slug', 'respiratory')
            ->update(['icon' => '🫁']);
    }
};
