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
        $this->app->bind(
            \App\Contracts\Services\OrderServiceInterface::class,
            \App\Services\OrderService::class,
        );

        $this->app->bind(
            \App\Contracts\Repositories\OrderRepositoryInterface::class,
            \App\Repositories\OrderRepository::class,
        );

        $this->app->bind(
            \App\Contracts\Repositories\ProductRepositoryInterface::class,
            \App\Repositories\ProductRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
