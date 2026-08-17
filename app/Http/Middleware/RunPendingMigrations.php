<?php

namespace App\Http\Middleware;

use App\Support\Installer;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class RunPendingMigrations
{
    /**
     * Deploys never run `php artisan migrate` over SSH (same reasoning as
     * the .env/APP_KEY/storage-link bootstrapping in bootstrap/app.php),
     * and the setup wizard that normally runs it is only reachable before
     * the app is marked installed. Without this, a migration shipped in a
     * later deploy — like the one adding products.image_path — would
     * never actually apply on an already-installed site.
     *
     * Runs `migrate` through the same web PHP process serving the site
     * whenever a new migration file has been deployed, detected via a
     * cheap file count so the common case (nothing pending) costs no
     * database query at all.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! app()->environment('testing') && Installer::isInstalled()) {
            $this->runIfPending();
        }

        return $next($request);
    }

    private function runIfPending(): void
    {
        $migrationFiles = glob(database_path('migrations/*.php')) ?: [];
        $currentCount = count($migrationFiles);

        $markerPath = storage_path('app/migrations_applied_count.txt');
        $appliedCount = file_exists($markerPath) ? (int) file_get_contents($markerPath) : -1;

        if ($currentCount === $appliedCount) {
            return;
        }

        try {
            Artisan::call('migrate', ['--force' => true]);
            file_put_contents($markerPath, (string) $currentCount);
        } catch (Throwable $e) {
            // Don't break the request if migrations can't run right now
            // (e.g. the database is briefly unreachable) — leave the
            // marker unset so it's retried on the next request.
        }
    }
}
