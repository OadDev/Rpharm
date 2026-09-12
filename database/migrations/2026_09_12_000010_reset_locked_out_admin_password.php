<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * One-time recovery migration: the site owner was locked out of the
     * admin@gmail.com account and had no server/database access to reset
     * it directly. Sets a temporary password they were told out-of-band;
     * they're expected to change it immediately via the admin Profile
     * page once logged back in. Safe to leave in migration history since
     * the temporary password is worthless after that change.
     */
    public function up(): void
    {
        User::where('email', 'admin@gmail.com')->update([
            'password' => Hash::make('kPLBDlN7gHzppYFd'),
        ]);
    }

    public function down(): void
    {
        // Not reversible: the original password hash was never known.
    }
};
