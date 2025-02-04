<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserAuthRepositoryInterface;
use App\Repositories\UserAuthRepository;
use App\Interfaces\ProductDraftRepositoryInterface;
use App\Repositories\ProductDraftRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserAuthRepositoryInterface::class, UserAuthRepository::class);
        $this->app->bind(ProductDraftRepositoryInterface::class, ProductDraftRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
