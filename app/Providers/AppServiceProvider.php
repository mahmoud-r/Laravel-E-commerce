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

            $stripe = getPaymentMethod('stripe');
            $paypal = getPaymentMethod('paypal');

            Config::set('mail.from.address', $settings['email_from_address'] ?? env('MAIL_FROM_ADDRESS', 'hello@example.com'));
            Config::set('mail.from.name', $settings['email_from_name'] ?? env('MAIL_FROM_NAME', 'Example'));

            Config::set('app.name', $settings['store_name'] ?? env('APP_NAME', 'Laravel'));
            Config::set('services.stripe.key', $stripe['payment_stripe_client_id'] ?? env('STRIPE_KEY'));
            Config::set('services.stripe.secret', $stripe['payment_stripe_secret'] ?? env('STRIPE_SECRET'));
            Config::set('services.stripe.webhook_secret', $stripe['payment_stripe_webhook_secret'] ?? env('STRIPE_WEBHOOK_SECRET'));
            Config::set('services.stripe.status', $stripe['status'] ?? env('STRIPE_STATUS'));
            Config::set('paypal.sandbox.client_id', $paypal['payment_paypal_client_id'] ?? env('PAYPAL_CLIENT'));
            Config::set('paypal.live.client_id', $paypal['payment_paypal_client_id'] ?? env('PAYPAL_CLIENT'));
            Config::set('paypal.sandbox.client_secret', $paypal['payment_paypal_client_secret'] ?? env('PAYPAL_SECRET'));
            Config::set('paypal.live.client_secret', $paypal['payment_paypal_client_secret'] ?? env('PAYPAL_SECRET'));
            Config::set('paypal.mode', $paypal['payment_paypal_mode'] ?? env('PAYPAL_MODE'));
            Config::set('paypal.status', $paypal['status'] ?? env('PAYPAL_STATUS'));
            Config::set('recaptchav3.sitekey', $settings['recaptcha_site_key'] ?? env('RECAPTCHAV3_SITEKEY', ''));
            Config::set('recaptchav3.secret', $settings['recaptcha_secret'] ?? env('RECAPTCHAV3_SECRET', ''));

            Config::set('services.facebook.client_id', $settings['facebook_client_id'] ?? env('FACEBOOK_CLIENT_ID'));
            Config::set('services.facebook.client_secret', $settings['facebook_client_secret'] ?? env('FACEBOOK_CLIENT_SECRET'));
            Config::set('services.facebook.redirect', $settings['facebook_redirect'] ?? env('FACEBOOK_REDIRECT'));
            Config::set('services.facebook.status', $settings['facebook_login_status'] ?? env('FACEBOOK_STATUS'));

            Config::set('services.google.client_id', $settings['google_client_id'] ?? env('GOOGLE_CLIENT_ID'));
            Config::set('services.google.client_secret', $settings['google_client_secret'] ?? env('GOOGLE_CLIENT_SECRET'));
            Config::set('services.google.redirect', $settings['google_redirect'] ?? env('GOOGLE_REDIRECT'));
            Config::set('services.google.status', $settings['google_login_status'] ?? env('GOOGLE_STATUS'));


        }
    }
}
