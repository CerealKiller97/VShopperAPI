<?php

use Illuminate\Database\Seeder;

class DiscountGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\DiscountGroup::class, 5)->create();

    }
}
