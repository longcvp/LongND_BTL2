<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\User\UserRepositoryInterface;
use App\Repositories\User\UserEloquentRepository;
use App\Repositories\Active\ActiveRepositoryInterface;
use App\Repositories\Active\ActiveEloquentRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Category\CategoryEloquentRepository;
use App\Repositories\Wallet\WalletRepositoryInterface;
use App\Repositories\Wallet\WalletEloquentRepository;
use App\Repositories\Transaction\TransactionRepositoryInterface;
use App\Repositories\Transaction\TransactionEloquentRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserEloquentRepository::class
        );

        $this->app->singleton(
            TransactionRepositoryInterface::class,
            TransactionEloquentRepository::class
        );

        $this->app->singleton(
            CategoryRepositoryInterface::class,
            CategoryEloquentRepository::class
        );

        $this->app->singleton(
            WalletRepositoryInterface::class,
            WalletEloquentRepository::class
        );

        $this->app->singleton(
            ActiveRepositoryInterface::class,
            ActiveEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
