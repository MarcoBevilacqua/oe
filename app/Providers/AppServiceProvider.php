<?php

namespace App\Providers;

use App\Http\Controllers\SpeciesByCategoryController;
use App\Http\Controllers\SpeciesByClassController;
use App\Http\Filters\SpeciesCategoryFilter;
use App\Http\Filters\SpeciesClassFilter;
use App\Interfaces\Filter;
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
        // contextual binding
        $this->app->when(SpeciesByCategoryController::class)
            ->needs(Filter::class)
            ->give(function () {
                return new SpeciesCategoryFilter();
            });

        // contextual binding
        $this->app->when(SpeciesByClassController::class)
            ->needs(Filter::class)
            ->give(function () {
                return new SpeciesClassFilter();
            });
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
