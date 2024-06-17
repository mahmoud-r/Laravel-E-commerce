<?php

namespace App\Providers;

use App\Models\Settings;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->booted(function () {
            $this->loadSettings();
        });
        Paginator::useBootstrapFive();
    }
    protected function loadSettings()
    {
        if (Schema::hasTable('settings')) {
            $settings = Settings::all()->pluck('value', 'key')->toArray();
            foreach ($settings as $key => $value) {
                Config::set('settings.' . $key, $value);
            }

            Config::set('mail.from.address', $settings['email_from_address'] ?? env('MAIL_FROM_ADDRESS', 'hello@example.com'));
            Config::set('mail.from.name', $settings['email_from_name'] ?? env('MAIL_FROM_NAME', 'Example'));

            Config::set('app.name', $settings['store_name'] ?? env('APP_NAME', 'Laravel'));

        }
    }
}
