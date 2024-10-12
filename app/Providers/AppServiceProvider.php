<?php

namespace App\Providers;

use App\Facades\ApiSuccess;
use App\Http\Responses\ApiSuccessResponse;
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
        $this->app->singleton('api.success', function ($app) {
            return new ApiSuccessResponse(null);
        });
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
