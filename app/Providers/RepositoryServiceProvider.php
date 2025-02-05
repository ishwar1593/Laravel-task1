<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserAuthRepositoryInterface;
use App\Repositories\UserAuthRepository;
use App\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;
use App\Interfaces\MoleculeRepositoryInterface;
use App\Repositories\MoleculeRepository;
use App\Interfaces\DraftProductRepositoryInterface;
use App\Repositories\DraftProductRepository;
use App\Interfaces\PublishedProductRepositoryInterface;
use App\Repositories\PublishedProductRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserAuthRepositoryInterface::class, UserAuthRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(MoleculeRepositoryInterface::class, MoleculeRepository::class);
        $this->app->bind(DraftProductRepositoryInterface::class, DraftProductRepository::class);
        $this->app->bind(PublishedProductRepositoryInterface::class, PublishedProductRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
