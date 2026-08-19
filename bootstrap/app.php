<?php

use App\Http\Middleware\RedirectIfNotInstalled;
use App\Http\Middleware\RunPendingMigrations;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Bootstrap .env on first deploy
|--------------------------------------------------------------------------
|
| The deploy pipeline intentionally never runs `php artisan` over SSH —
| the SSH shell's default `php` binary on shared hosting is often an
| older version than the one actually serving the site, so artisan
| commands run there can fail even when the site itself works fine.
| This runs before the framework boots (and before anything, like the
| encrypter, needs APP_KEY), so the setup wizard has a working .env to
| write into on the very first request.
|
| Also repairs a .env that exists but has a blank APP_KEY: a deploy can
| get as far as `cp .env.example .env` (plain shell, always works) and
| then fail before the key ever gets generated, leaving a file that
| exists but doesn't satisfy the framework.
*/
$envPath = dirname(__DIR__).'/.env';
$envExamplePath = dirname(__DIR__).'/.env.example';

if (! file_exists($envPath) && file_exists($envExamplePath)) {
    copy($envExamplePath, $envPath);
}

if (file_exists($envPath)) {
    $envContent = file_get_contents($envPath);

    if (! preg_match('/^APP_KEY=base64:.+$/m', $envContent)) {
        $newKeyLine = 'APP_KEY=base64:'.base64_encode(random_bytes(32));

        $envContent = preg_match('/^APP_KEY=.*$/m', $envContent)
            ? preg_replace('/^APP_KEY=.*$/m', $newKeyLine, $envContent)
            : rtrim($envContent)."\n".$newKeyLine."\n";

        file_put_contents($envPath, $envContent);
    }
}

/*
|--------------------------------------------------------------------------
| Repair a placeholder APP_URL
|--------------------------------------------------------------------------
|
| APP_URL feeds every absolute URL the app generates, including uploaded
| file links (Storage::disk('public')->url()). Left at the .env.example
| default of http://localhost, every uploaded image, logo, and product
| photo would silently point at the wrong host. Detects the real host
| from the incoming request and writes it in, but only ever replaces the
| untouched placeholder — never overwrites a value someone set on purpose.
*/
if (PHP_SAPI !== 'cli' && isset($_SERVER['HTTP_HOST']) && file_exists($envPath)) {
    $envContent = file_get_contents($envPath);

    if (preg_match('/^APP_URL=(.*)$/m', $envContent, $matches)) {
        $currentUrl = trim($matches[1], "\"' \t");

        if (in_array($currentUrl, ['', 'http://localhost'], true)) {
            $isHttps = (! empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
                || ($_SERVER['SERVER_PORT'] ?? null) == 443
                || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? null) === 'https';
            $detectedUrl = ($isHttps ? 'https://' : 'http://').$_SERVER['HTTP_HOST'];

            file_put_contents($envPath, preg_replace('/^APP_URL=.*$/m', 'APP_URL='.$detectedUrl, $envContent));
        }
    }
}

/*
|--------------------------------------------------------------------------
| Ensure the public storage symlink exists
|--------------------------------------------------------------------------
|
| Uploaded files (product photos, testimonial avatars, the site logo)
| are only served if public/storage links to storage/app/public. Normally
| that's `php artisan storage:link`, but for the same reason as above this
| can't depend on a working SSH shell — so it's created here instead.
*/
$storageLinkPath = dirname(__DIR__).'/public/storage';
$storageTargetPath = dirname(__DIR__).'/storage/app/public';

if (is_dir($storageTargetPath) && ! (is_link($storageLinkPath) && file_exists($storageLinkPath))) {
    if (is_link($storageLinkPath)) {
        // A dangling symlink (target was ever moved/recreated) still
        // occupies this path, so a plain symlink() call below would
        // silently fail with "File exists" — clear it first.
        @unlink($storageLinkPath);
    } elseif (is_dir($storageLinkPath) && count(scandir($storageLinkPath)) <= 2) {
        // Some hosting setups end up with public/storage as a real, empty
        // directory instead of a symlink (e.g. from a manual mkdir while
        // troubleshooting) — uploaded files would silently never appear
        // here. Only remove it if it's verifiably empty, never one holding
        // actual files.
        @rmdir($storageLinkPath);
    }

    if (! file_exists($storageLinkPath)) {
        @symlink($storageTargetPath, $storageLinkPath);
    }
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(RedirectIfNotInstalled::class);
        $middleware->append(RunPendingMigrations::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
