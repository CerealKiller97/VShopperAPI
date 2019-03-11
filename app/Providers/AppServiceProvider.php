<?php

namespace App\Providers;

use App\Contracts\UnitContract;
use App\Contracts\BrandContract;
use App\Contracts\VendorContract;
use App\Contracts\AccountContract;
use App\Contracts\ProductContract;
use App\Contracts\StorageContract;
use App\Contracts\CategoryContract;
use App\Services\UnitEloquentService;
use App\Services\BrandEloquentService;
use Illuminate\Support\Facades\Schema;
use App\Services\VendorEloquentService;
use Illuminate\Support\ServiceProvider;
use App\Services\AccountEloquentService;
use App\Services\ProductEloquentService;
use App\Services\StorageEloquentService;
use App\Services\CategoryEloquentService;

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
        $this->app->bind(CategoryContract::class, CategoryEloquentService::class);
        $this->app->bind(BrandContract::class, BrandEloquentService::class);
        $this->app->bind(VendorContract::class, VendorEloquentService::class);
        $this->app->bind(StorageContract::class, StorageEloquentService::class);
        $this->app->bind(UnitContract::class, UnitEloquentService::class);

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
