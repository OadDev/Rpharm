<?php

namespace App\Providers;

use App\Models\Office;
use App\Models\Setting;
use App\Support\MediaUrl;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

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

        $this->configureMailFromSettings();
    }

    /**
     * Admins configure SMTP (Gmail) credentials from the admin panel rather
     * than editing server .env files, so pull them from the settings table
     * and apply them over the default mail config when present.
     */
    protected function configureMailFromSettings(): void
    {
        try {
            if (! Schema::hasTable('settings')) {
                return;
            }

            $host = Setting::get('mail_host');

            if (blank($host)) {
                return;
            }

            $encryptedPassword = Setting::get('mail_password');
            $password = null;

            if (filled($encryptedPassword)) {
                try {
                    $password = Crypt::decryptString($encryptedPassword);
                } catch (Throwable) {
                    $password = null;
                }
            }

            Config::set('mail.default', 'smtp');
            Config::set('mail.mailers.smtp.host', $host);
            Config::set('mail.mailers.smtp.port', (int) Setting::get('mail_port', '587'));
            Config::set('mail.mailers.smtp.scheme', Setting::get('mail_encryption', 'tls') === 'ssl' ? 'smtps' : 'smtp');
            Config::set('mail.mailers.smtp.username', Setting::get('mail_username'));
            Config::set('mail.mailers.smtp.password', $password);
            Config::set('mail.from.address', Setting::get('mail_from_address', Setting::get('mail_username')));
            Config::set('mail.from.name', Setting::get('mail_from_name', config('app.name')));
        } catch (Throwable) {
            // Fall back to the .env-configured mailer if settings can't be read.
        }
    }
}
