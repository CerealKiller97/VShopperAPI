<?php

namespace App\Providers;

use App\Contracts\AccountContract;
use App\Contracts\ProductContract;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\Services\AccountEloquentService;
use App\Services\ProductEloquentService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        $this->app->bind(AccountContract::class, AccountEloquentService::class);
        $this->app->bind(ProductContract::class, ProductEloquentService::class);


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
