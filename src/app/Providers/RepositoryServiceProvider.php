<?php

namespace App\Providers;

use App\Repository\CarrierRepository;
use App\Repository\Contracts\CarrierRepositoryInterface;
use App\Repository\Contracts\DeliveryRepositoryInterface;
use App\Repository\Contracts\RecipientRepositoryInterface;
use App\Repository\Contracts\SenderRepositoryInterface;
use App\Repository\DeliveryRepository;
use App\Repository\RecipientRepository;
use App\Repository\SenderRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(CarrierRepositoryInterface::class, CarrierRepository::class);
        $this->app->singleton(SenderRepositoryInterface::class, SenderRepository::class);
        $this->app->singleton(RecipientRepositoryInterface::class, RecipientRepository::class);
        $this->app->singleton(DeliveryRepositoryInterface::class, DeliveryRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
