<?php

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;

class ImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $images = [
            'Spalding-Digital-Assets_4384.png', 'd640546f-7384-41cc-a255-34916e088163_1.4ac946718614045a43b4f80cbfc2e76f.jpeg',
            'macbook-pro-windows-01.jpg',
            'crvg7yroprzmj5p2z2yn.jpeg',
            's-l300.jpg'
        ];

        foreach ($images as $image)
        {
            DB::table('images')->insert([
                'src' => 'images/' . $image,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
