<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

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
        $this->configureRateLimiting();
    }


    /**
     * Configure the rate limiting.
     *
     * @return void
     */
    private function configureRateLimiting(): void
    {
        // Rate limit the API requests to 60 requests per minute by user id or IP address.
        RateLimiter::for('api', fn(Request $request) => Limit::perMinute(60)->by($request->user()?->id ?: $request->ip()));

        // Rate limit the authentication requests to 5 requests per minute by IP address.
        RateLimiter::for('auth', fn(Request $request) => Limit::perMinute(5)->by($request->ip()));

        // Rate limit the authenticated requests to 120 requests per minute by user id and 60 requests per minute by IP address.
        RateLimiter::for('authenticated', fn(Request $request) => $request->user()
            ? Limit::perMinute(120)->by($request->user()->id)
            : Limit::perMinute(60)->by($request->ip()));
    }
}
