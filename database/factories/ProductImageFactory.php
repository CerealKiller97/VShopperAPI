<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProductImage::class, function (Faker $faker) {
    return [
        'product_id' => rand(1, 5),
        'image_id'   => rand(1, 5)
    ];
});
