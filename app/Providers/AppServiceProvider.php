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
        $this->app->bind(AccountContract::class, AccountEloquentService::class);
        $this->app->bind(ProductContract::class, ProductEloquentService::class);
        $this->app->bind(CategoryContract::class, CategoryEloquentService::class);
        $this->app->bind(BrandContract::class, BrandEloquentService::class);
        $this->app->bind(VendorContract::class, VendorEloquentService::class);
        $this->app->bind(StorageContract::class, StorageEloquentService::class);
        $this->app->bind(UnitContract::class, UnitEloquentService::class);
        $this->app->bind(GroupContract::class, GroupEloquentService::class);
        $this->app->bind(ProductTypeContract::class, ProductTypeEloquentService::class);
        $this->app->bind(StorageTypeContract::class, StorageTypeEloquentService::class);
        $this->app->bind(StorageImageContract::class, StorageImageEloquentService::class);
        $this->app->bind(ProductStorageContract::class, ProductStorageEloquentService::class);
        $this->app->bind(ProductImageContract::class, ProductImageEloquentService::class);
        $this->app->bind(ProductPriceContract::class, ProductPriceEloquentService::class);
        $this->app->bind(ProductDiscountContract::class, ProductDiscountEloquentService::class);


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
