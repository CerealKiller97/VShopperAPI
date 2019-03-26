<?php

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name'       => 'physical',
                'account_id' => null
            ],
            [
                'name'       => 'digital',
                'account_id' => null
            ]
        ];

        foreach ($data as $item) {
            ProductType::create($item);
        }
    }
}
