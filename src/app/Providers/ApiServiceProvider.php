<?php

namespace App\Providers;

use App\Services\Interfaces\ApiServiceInterface;
use App\Services\JsonApiMockService;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(
            ApiServiceInterface::class,
            JsonApiMockService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
