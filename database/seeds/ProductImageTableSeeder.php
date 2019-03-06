<?php

use Illuminate\Database\Seeder;

class ProductImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\ProductImage::class, 5)->create();
    }
}
