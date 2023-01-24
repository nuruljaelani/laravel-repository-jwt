<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryImpl;
use App\Repositories\User\UserRepository;
use App\Repositories\User\UserRepositoryImpl;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, UserRepositoryImpl::class);
        $this->app->bind(CategoryRepository::class, CategoryRepositoryImpl::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
