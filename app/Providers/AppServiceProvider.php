<?php

namespace App\Providers;

use App\Models\Office;
use App\Models\Setting;
use App\Support\MediaUrl;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
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
        if (! $this->app->runningInConsole()) {
            URL::forceRootUrl(request()->getSchemeAndHttpHost());
        }

        View::composer(
            ['partials.nav', 'partials.footer', 'home', 'process'],
            function ($view) {
                $settings = Schema::hasTable('settings') ? Setting::pluck('value', 'key') : collect();

                if ($settings->has('logo_url')) {
                    $settings->put('logo_url', MediaUrl::resolve($settings->get('logo_url')));
                }

                $view->with('settings', $settings);
            }
        );

        View::composer('partials.footer', function ($view) {
            $view->with('offices', Schema::hasTable('offices') ? Office::orderBy('sort_order')->get() : collect());
        });
    }
}
