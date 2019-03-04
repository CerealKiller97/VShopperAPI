<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ImageTableSeeder::class,
            AccountTableSeeder::class,
            VendorTableSeeder::class,
            StorageTypeSeeder::class,
            UnitTableSeeder::class,
            ProductTypTableSeeder::class
        ]);



    }
}
