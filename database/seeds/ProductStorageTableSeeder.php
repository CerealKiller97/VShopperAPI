<?php

use Illuminate\Database\Seeder;

class ProductStorageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\ProductStorage::class, 5)->create();
    }
}
