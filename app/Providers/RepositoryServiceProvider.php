<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Repositories\Interfaces\ProductRepositoryInterface::class,
            \App\Repositories\ProductRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\QcHistoryRepositoryInterface::class,
            \App\Repositories\QcHistoryRepository::class
        );
        $this->app->bind(
            \App\Repositories\Interfaces\StockMutationRepositoryInterface::class,
            \App\Repositories\StockMutationRepository::class
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
