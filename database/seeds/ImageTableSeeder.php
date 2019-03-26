<?php

use App\Models\Image;
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
            [
                'src' => 'images/Spalding-Digital-Assets_4384.png'
            ],
            [
                'src' => 'images/d640546f-7384-41cc-a255-34916e088163_1.4ac946718614045a43b4f80cbfc2e76f.jpeg'
            ],
            [
                'src' => 'images/macbook-pro-windows-01.jpg'
            ],
            [
                'src' => 'images/crvg7yroprzmj5p2z2yn.jpeg'
            ],
            [
                'src' => 'images/s-l300.jpg'
            ]
        ];

        foreach ($images as $image)
        {
            Image::create($image);
        }
    }
}
