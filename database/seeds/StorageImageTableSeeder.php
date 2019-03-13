<?php

use Illuminate\Database\Seeder;

class StorageImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\StorageImage::class, 5)->create();
    }
}
