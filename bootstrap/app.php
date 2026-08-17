<?php

use App\Http\Middleware\RedirectIfNotInstalled;
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
*/
$envPath = dirname(__DIR__).'/.env';
$envExamplePath = dirname(__DIR__).'/.env.example';

if (! file_exists($envPath) && file_exists($envExamplePath)) {
    copy($envExamplePath, $envPath);

    file_put_contents($envPath, preg_replace(
        '/^APP_KEY=.*$/m',
        'APP_KEY=base64:'.base64_encode(random_bytes(32)),
        file_get_contents($envPath)
    ));
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->append(RedirectIfNotInstalled::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
