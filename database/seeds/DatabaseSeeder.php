<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([
            ImageTableSeeder::class,
            AccountTableSeeder::class,
            VendorTableSeeder::class,
            StorageTypeSeeder::class,
            UnitTableSeeder::class,
            ProductTypTableSeeder::class,
            CategoryTableSeeder::class,
            BrandTableSeeder::class,
            StorageTableSeeder::class,
            ProductTableSeeder::class,
            GroupTableSeeder::class,
            ProductImageTableSeeder::class,
            CategoryProductTableSeeder::class,
            ProductStorageTableSeeder::class,
            DiscountTableSeeder::class,
            DiscountGroupTableSeeder::class,
            StorageImageTableSeeder::class,
            PriceTableSeeder::class
        ]);
    }
}
