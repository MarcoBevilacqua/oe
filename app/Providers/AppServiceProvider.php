<?php

namespace App\Providers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Vite;
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
        Vite::prefetch(concurrency: 3);

        // http client macro
        Http::macro('iucn', function () {
            return Http::baseUrl(
                config('api.iucn.base_url') . config('api.iucn.version')
            )->withQueryParameters(['token' => config('api.iucn.token')]);
        });
    }
}
