<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
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
              'name' => 'Phones',
              'account_id' => null,
              'subcategory_id' => null,
              'image_id' => null
            ],
            [
                'name' => 'Sport',
                'account_id' => null,
                'subcategory_id' => null,
                'image_id' => null
            ],
            [
                'name' => 'Hardware',
                'account_id' => null,
                'subcategory_id' => null,
                'image_id' => null
            ],
            [
                'name' => 'Software',
                'account_id' => null,
                'subcategory_id' => null,
                'image_id' => null
            ],
            [
                'name' => 'Cars',
                'account_id' => null,
                'subcategory_id' => null,
                'image_id' => null
            ]
        ];

        foreach($data as $unit)
        {
            Category::create($unit);
        }

        // factory(App\Models\Category::class, 5)->create();
    }
}
