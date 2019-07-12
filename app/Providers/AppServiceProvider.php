<?php

namespace App\Providers;

use App\Contracts\{
    UnitContract,
    BrandContract,
    GroupContract,
    VendorContract,
    AccountContract,
    ProductContract,
    StorageContract,
    CategoryContract,
    ProductTypeContract,
    StorageTypeContract,
    ProductImageContract,
    ProductPriceContract,
    StorageImageContract,
    ProductStorageContract,
    ProductDiscountContract

};

use App\Services\{
    UnitEloquentService,
    BrandEloquentService,
    GroupEloquentService,
    VendorEloquentService,
    AccountEloquentService,
    ProductEloquentService,
    ProductDiscountEloquentService,
    ProductImageEloquentService,
    ProductStorageEloquentService,
    StorageImageEloquentService,
    ProductPriceEloquentService,
    StorageTypeEloquentService,
    ProductTypeEloquentService,
    CategoryEloquentService,
    StorageEloquentService

};

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

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
