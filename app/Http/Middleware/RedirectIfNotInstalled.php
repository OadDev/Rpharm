<?php

namespace App\Http\Middleware;

use App\Support\Installer;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotInstalled
{
    public function handle(Request $request, Closure $next): Response
    {
        if (app()->environment('testing')) {
            return $next($request);
        }

        if (! Installer::isInstalled() && ! $request->is('setup', 'setup/*', 'up')) {
            return redirect('/setup');
        }

        if (Installer::isInstalled() && $request->is('setup', 'setup/*')) {
            return redirect('/');
        }

        return $next($request);
    }
}
