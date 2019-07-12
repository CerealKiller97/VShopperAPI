<?php

namespace App\Providers;

use App\Contracts\UnitContract;
use App\Contracts\BrandContract;
use App\Contracts\GroupContract;
use App\Contracts\VendorContract;
use App\Contracts\AccountContract;
use App\Contracts\ProductContract;
use App\Contracts\StorageContract;
use App\Contracts\CategoryContract;
use App\Services\UnitEloquentService;
use App\Contracts\ProductTypeContract;
use App\Contracts\StorageTypeContract;
use App\Services\BrandEloquentService;
use App\Services\GroupEloquentService;
use Illuminate\Support\Facades\Schema;
use App\Contracts\ProductImageContract;
use App\Contracts\ProductPriceContract;
use App\Contracts\StorageImageContract;
use App\Services\VendorEloquentService;
use Illuminate\Support\ServiceProvider;
use App\Services\AccountEloquentService;
use App\Services\ProductEloquentService;
use App\Services\StorageEloquentService;
use App\Contracts\ProductStorageContract;
use App\Services\CategoryEloquentService;
use App\Contracts\ProductDiscountContract;
use App\Services\ProductTypeEloquentService;
use App\Services\StorageTypeEloquentService;
use App\Services\ProductImageEloquentService;
use App\Services\ProductPriceEloquentService;
use App\Services\StorageImageEloquentService;
use App\Services\ProductStorageEloquentService;
use App\Services\ProductDiscountEloquentService;

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

        $this->app->singleton(AccountContract::class, AccountEloquentService::class);
        $this->app->singleton(ProductContract::class, ProductEloquentService::class);
        $this->app->singleton(CategoryContract::class, CategoryEloquentService::class);
        $this->app->singleton(BrandContract::class, BrandEloquentService::class);
        $this->app->singleton(VendorContract::class, VendorEloquentService::class);
        $this->app->singleton(StorageContract::class, StorageEloquentService::class);
        $this->app->singleton(UnitContract::class, UnitEloquentService::class);
        $this->app->singleton(GroupContract::class, GroupEloquentService::class);
        $this->app->singleton(ProductTypeContract::class, ProductTypeEloquentService::class);
        $this->app->singleton(StorageTypeContract::class, StorageTypeEloquentService::class);
        $this->app->singleton(StorageImageContract::class, StorageImageEloquentService::class);
        $this->app->singleton(ProductStorageContract::class, ProductStorageEloquentService::class);
        $this->app->singleton(ProductImageContract::class, ProductImageEloquentService::class);
        $this->app->singleton(ProductPriceContract::class, ProductPriceEloquentService::class);
        $this->app->singleton(ProductDiscountContract::class, ProductDiscountEloquentService::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
