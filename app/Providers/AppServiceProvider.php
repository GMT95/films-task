<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\FilmsService;
use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\FilmsServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        /* Bind Services Class to Service Interface */
        $this->app->bind(FilmsServiceInterface::class, FilmsService::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
