<?php

namespace App\Providers;

use App\Models\Office;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(
            ['partials.nav', 'partials.footer', 'home', 'process'],
            function ($view) {
                $view->with('settings', Schema::hasTable('settings') ? Setting::pluck('value', 'key') : collect());
            }
        );

        View::composer('partials.footer', function ($view) {
            $view->with('offices', Schema::hasTable('offices') ? Office::orderBy('sort_order')->get() : collect());
        });
    }
}
