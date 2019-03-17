<?php

use Faker\Generator as Faker;

$factory->define(App\Models\StorageImage::class, function (Faker $faker) {
    return [
        'storage_id' => rand(1, 5),
        'image_id'   => rand(1, 5)
    ];
});
