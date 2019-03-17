<?php

use Faker\Generator as Faker;

$factory->define(App\Models\ProductStorage::class, function (Faker $faker) {
    return [
        'product_id' => rand(1, 5),
        'storage_id' => rand(1, 5),
        'quantity' => rand(1, 100)
    ];
});
