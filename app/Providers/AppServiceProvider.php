<?php

namespace App\Providers;

use App\Models\Adds;
use App\Models\Company;
use App\Observers\AddsObserver;
use App\Observers\CompanyObserver;
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
        Company::observe(CompanyObserver::class);
        Adds::observe(AddsObserver::class);
    }
}
