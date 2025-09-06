<?php

namespace App\Providers;

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
        // Force URL generation to use the current request's scheme and host
        if (request()->header('host')) {
            $protocol = request()->isSecure() ? 'https' : 'http';
            $host = request()->header('host');
            \Illuminate\Support\Facades\URL::forceRootUrl("{$protocol}://{$host}");
        }
        
        // Force HTTPS in production
        if (app()->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
